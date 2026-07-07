<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\DealerTransaction;
use App\Models\Payment;
use App\Models\StockItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DealerTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = DealerTransaction::with('dealer');
        if ($request->filled('dealer_id')) {
            $query->where('dealer_id', $request->dealer_id);
        }
        if ($request->filled('dues_only')) {
            $query->where('due_amount', '>', 0);
        }
        $transactions = $query->latest('date')->paginate(20)->withQueryString();
        $dealers = Dealer::orderBy('name')->get();
        return view('dealer-transactions.index', compact('transactions', 'dealers'));
    }

    public function create()
    {
        $dealers = Dealer::where('is_active', true)->orderBy('name')->get();
        return view('dealer-transactions.create', compact('dealers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dealer_id'   => 'required|exists:dealers,id',
            'type'        => 'required|in:purchase,borrow',
            'date'        => 'required|date',
            'due_date'    => 'nullable|date|after_or_equal:date',
            'no_items'    => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'notes'       => 'nullable|string',
            'items'       => 'required|array|min:1',
            'items.*.imei1'         => 'required|string|digits:15|distinct',
            'items.*.imei2'         => 'nullable|string|digits:15',
            'items.*.brand'         => 'required|string|max:100',
            'items.*.model'         => 'required|string|max:100',
            'items.*.variant'       => 'nullable|string|max:100',
            'items.*.color'         => 'nullable|string|max:50',
            'items.*.cost_price'    => 'required|numeric|min:0',
           // 'items.*.selling_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $totalAmount = collect($request->items)->sum('cost_price');
            $paidAmount  = (float) $request->paid_amount;
            $dueAmount   = max(0, $totalAmount - $paidAmount);

            $txn = DealerTransaction::create([
                'dealer_id'    => $request->dealer_id,
                'type'         => $request->type,
                'total_amount' => $totalAmount,
                'paid_amount'  => $paidAmount,
                'due_amount'   => $dueAmount,
                'date'         => $request->date,
                'due_date'     => $request->due_date,
                'notes'        => $request->notes,
            ]);

            foreach ($request->items as $item) {
                StockItem::create([
                    'imei1'               => $item['imei1'],
                    'imei2'               => $item['imei2'] ?? null,
                    'brand'               => $item['brand'],
                    'model'               => $item['model'],
                    'variant'             => $item['variant'] ?? null,
                    'color'               => $item['color'] ?? null,
                    'dealer_id'           => $request->dealer_id,
                    'dealer_transaction_id' => $txn->id,
                    'cost_price'          => $item['cost_price'],
                 //   'selling_price'       => $item['selling_price'],
                    'status'              => 'in_stock',
                    'date_added'          => $request->date,
                ]);
            }

            // Update dealer due
            $dealer = $txn->dealer;
            $dealer->increment('total_due', $dueAmount);

            // Record initial payment if any
            if ($paidAmount > 0) {
                Payment::create([
                    'type'           => 'dealer',
                    'transaction_id' => $txn->id,
                    'amount'         => $paidAmount,
                    'mode'           => $request->payment_mode ?? 'cash',
                    'date'           => $request->date,
                    'notes'          => 'Initial payment on purchase',
                ]);
            }
        });

        return redirect()->route('dealer-transactions.index')->with('success', 'Dealer transaction recorded.');
    }

    public function show(DealerTransaction $dealerTransaction)
    {
        $dealerTransaction->load('dealer', 'stockItems', 'payments');
        return view('dealer-transactions.show', compact('dealerTransaction'));
    }

    public function pay(Request $request, DealerTransaction $dealerTransaction)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $dealerTransaction->due_amount,
            'mode'   => 'required|in:cash,upi,card,bank_transfer,other',
            'date'   => 'required|date',
            'notes'  => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $dealerTransaction) {
            Payment::create([
                'type'           => 'dealer',
                'transaction_id' => $dealerTransaction->id,
                'amount'         => $request->amount,
                'mode'           => $request->mode,
                'date'           => $request->date,
                'notes'          => $request->notes,
            ]);

            $dealerTransaction->increment('paid_amount', $request->amount);
            $dealerTransaction->decrement('due_amount', $request->amount);

            $dealerTransaction->dealer->decrement('total_due', $request->amount);
        });

        return back()->with('success', 'Payment recorded.');
    }

    public function returnItems(Request $request, DealerTransaction $dealerTransaction)
    {
        $request->validate([
            'stock_item_ids'   => 'required|array|min:1',
            'stock_item_ids.*' => 'exists:stock_items,id',
        ]);

        DB::transaction(function () use ($request, $dealerTransaction) {
            $items = StockItem::whereIn('id', $request->stock_item_ids)
                ->where('dealer_transaction_id', $dealerTransaction->id)
                ->where('status', 'in_stock')
                ->get();

            $returnValue = $items->sum('cost_price');

            foreach ($items as $item) {
                $item->update(['status' => 'returned']);
            }

            // Reduce transaction amounts and dealer due proportionally
            $reduce = min($returnValue, $dealerTransaction->due_amount);
            $dealerTransaction->decrement('due_amount', $reduce);
            $dealerTransaction->decrement('total_amount', $returnValue);
            $dealerTransaction->dealer->decrement('total_due', $reduce);
        });

        return back()->with('success', 'Items returned to dealer.');
    }
}
