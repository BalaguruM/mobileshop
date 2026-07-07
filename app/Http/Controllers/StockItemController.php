<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\StockItem;
use Illuminate\Http\Request;

class StockItemController extends Controller
{
    public function index(Request $request)
    {
        $query = StockItem::with('dealer');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('imei1', 'like', "%$s%")
                  ->orWhere('imei2', 'like', "%$s%")
                  ->orWhere('brand', 'like', "%$s%")
                  ->orWhere('model', 'like', "%$s%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        $items  = $query->latest()->paginate(25)->withQueryString();
        $brands = StockItem::select('brand')->distinct()->orderBy('brand')->pluck('brand');
        return view('stock.index', compact('items', 'brands'));
    }

    public function create()
    {
        $dealers = Dealer::where('is_active', true)->orderBy('name')->get();
        return view('stock.create', compact('dealers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'imei1'          => 'required|string|max:20|unique:stock_items,imei1',
            'imei2'          => 'nullable|string|max:20',
            'brand'          => 'required|string|max:100',
            'model'          => 'required|string|max:100',
            'variant'        => 'nullable|string|max:100',
            'color'          => 'nullable|string|max:50',
            'dealer_id'      => 'nullable|exists:dealers,id',
            'cost_price'     => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'date_added'     => 'required|date',
            'warranty_period'=> 'nullable|string|max:50',
            'box_contents'   => 'nullable|string',
        ]);
        StockItem::create($data);
        return redirect()->route('stock.index')->with('success', 'Stock item added.');
    }

    public function show(StockItem $stock)
    {
        $stock->load('dealer', 'dealerTransaction', 'saleItem.saleTransaction.customer');
        return view('stock.show', compact('stock'));
    }

    public function edit(StockItem $stock)
    {
        $dealers = Dealer::where('is_active', true)->orderBy('name')->get();
        return view('stock.edit', compact('stock', 'dealers'));
    }

    public function update(Request $request, StockItem $stock)
    {
        $data = $request->validate([
            'imei1'          => 'required|string|max:20|unique:stock_items,imei1,' . $stock->id,
            'imei2'          => 'nullable|string|max:20',
            'brand'          => 'required|string|max:100',
            'model'          => 'required|string|max:100',
            'variant'        => 'nullable|string|max:100',
            'color'          => 'nullable|string|max:50',
            'dealer_id'      => 'nullable|exists:dealers,id',
            'cost_price'     => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'date_added'     => 'required|date',
            'status'         => 'required|in:in_stock,sold,returned,damaged',
            'warranty_period'=> 'nullable|string|max:50',
            'box_contents'   => 'nullable|string',
        ]);
        $stock->update($data);
        return redirect()->route('stock.show', $stock)->with('success', 'Stock item updated.');
    }

    public function destroy(StockItem $stock)
    {
        $stock->delete();
        return redirect()->route('stock.index')->with('success', 'Stock item deleted.');
    }
}
