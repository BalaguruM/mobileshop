<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\SaleItem;
use App\Models\SaleTransaction;
use App\Models\StockItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = SaleTransaction::with('customer');
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
        if ($request->filled('dues_only')) {
            $query->where('due_amount', '>', 0);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }
        $sales     = $query->latest('date')->paginate(20)->withQueryString();
        $customers = Customer::orderBy('name')->get();
        return view('sales.index', compact('sales', 'customers'));
    }

    public function create()
    {
        $customers  = Customer::where('is_active', true)->orderBy('name')->get();
        $stockItems = StockItem::where('status', 'in_stock')
            ->select('id', 'imei1', 'brand', 'model', 'variant', 'color', 'selling_price')
            ->orderBy('brand')->orderBy('model')->get();
        return view('sales.create', compact('customers', 'stockItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_type'        => 'required|in:existing,walkin',
            'customer_id'          => 'nullable|exists:customers,id',
            'customer_name_override' => 'nullable|string|max:255',
            'payment_mode'         => 'required|in:cash,upi,card,credit,emi',
            'paid_amount'          => 'required|numeric|min:0',
            'date'                 => 'required|date',
            'due_date'             => 'nullable|date|after_or_equal:date',
            'discount'             => 'nullable|numeric|min:0',
            'notes'                => 'nullable|string',
            'items'                => 'required|array|min:1',
            'items.*'              => 'exists:stock_items,id',
            'selling_prices'       => 'required|array|min:1',
            'selling_prices.*'     => 'numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $stockItems  = StockItem::whereIn('id', $request->items)->where('status', 'in_stock')->get()->keyBy('id');
            $totalAmount = 0;
            foreach ($request->items as $itemId) {
                $totalAmount += $request->selling_prices[$itemId] ?? $stockItems[$itemId]->selling_price;
            }
            $discount    = (float) ($request->discount ?? 0);
            $netTotal    = $totalAmount - $discount;
            $paidAmount  = (float) $request->paid_amount;
            $dueAmount   = max(0, $netTotal - $paidAmount);

            $sale = SaleTransaction::create([
                'customer_id'             => $request->customer_type === 'existing' ? $request->customer_id : null,
                'customer_name_override'  => $request->customer_type === 'walkin' ? ($request->customer_name_override ?? 'Walk-in') : null,
                'total_amount'            => $netTotal,
                'discount'                => $discount,
                'paid_amount'             => $paidAmount,
                'due_amount'              => $dueAmount,
                'payment_mode'            => $request->payment_mode,
                'date'                    => $request->date,
                'due_date'                => $request->due_date,
                'notes'                   => $request->notes,
            ]);

            foreach ($request->items as $itemId) {
                $price = $request->selling_prices[$itemId] ?? $stockItems[$itemId]->selling_price;
                SaleItem::create([
                    'sale_transaction_id' => $sale->id,
                    'stock_item_id'       => $itemId,
                    'selling_price'       => $price,
                    'discount'            => 0,
                ]);
                $stockItems[$itemId]->update(['status' => 'sold']);
            }

            // Update customer due
            if ($sale->customer_id && $dueAmount > 0) {
                Customer::find($sale->customer_id)->increment('total_due', $dueAmount);
            }

            // Record initial payment
            if ($paidAmount > 0) {
                Payment::create([
                    'type'           => 'customer',
                    'transaction_id' => $sale->id,
                    'amount'         => $paidAmount,
                    'mode'           => $request->payment_mode,
                    'date'           => $request->date,
                    'notes'          => 'Payment at sale',
                ]);
            }
        });

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully.');
    }

    public function show(SaleTransaction $sale)
    {
        $sale->load('customer', 'saleItems.stockItem', 'payments');
        return view('sales.show', compact('sale'));
    }

    public function pay(Request $request, SaleTransaction $sale)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $sale->due_amount,
            'mode'   => 'required|in:cash,upi,card,bank_transfer,other',
            'date'   => 'required|date',
            'notes'  => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $sale) {
            Payment::create([
                'type'           => 'customer',
                'transaction_id' => $sale->id,
                'amount'         => $request->amount,
                'mode'           => $request->mode,
                'date'           => $request->date,
                'notes'          => $request->notes,
            ]);

            $sale->increment('paid_amount', $request->amount);
            $sale->decrement('due_amount', $request->amount);

            if ($sale->customer_id) {
                Customer::find($sale->customer_id)->decrement('total_due', $request->amount);
            }
        });

        return back()->with('success', 'Payment recorded.');
    }
}
