<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    public function index(Request $request)
    {
        $query = Dealer::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
        }
        $dealers = $query->orderBy('name')->paginate(20)->withQueryString();
        return view('dealers.index', compact('dealers'));
    }

    public function create()
    {
        return view('dealers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string',
            'gst_number' => 'nullable|string|max:20',
        ]);
        Dealer::create($data);
        return redirect()->route('dealers.index')->with('success', 'Dealer added successfully.');
    }

    public function show(Dealer $dealer)
    {
        $transactions = $dealer->transactions()->with('stockItems')->latest()->paginate(15);
        return view('dealers.show', compact('dealer', 'transactions'));
    }

    public function edit(Dealer $dealer)
    {
        return view('dealers.edit', compact('dealer'));
    }

    public function update(Request $request, Dealer $dealer)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string',
            'gst_number' => 'nullable|string|max:20',
            'is_active'  => 'boolean',
        ]);
        $dealer->update($data);
        return redirect()->route('dealers.show', $dealer)->with('success', 'Dealer updated.');
    }

    public function destroy(Dealer $dealer)
    {
        $dealer->delete();
        return redirect()->route('dealers.index')->with('success', 'Dealer deleted.');
    }
}
