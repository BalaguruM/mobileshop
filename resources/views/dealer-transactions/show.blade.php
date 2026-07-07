@extends('layouts.app')
@section('title', 'Purchase #' . $dealerTransaction->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Purchase #{{ $dealerTransaction->id }} — {{ $dealerTransaction->dealer->name }}</h4>
    <a href="{{ route('dealer-transactions.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th>Type</th><td><span class="badge bg-primary">{{ ucfirst($dealerTransaction->type) }}</span></td></tr>
                    <tr><th>Date</th><td>{{ $dealerTransaction->date->format('d M Y') }}</td></tr>
                    <tr><th>Due Date</th><td>{{ $dealerTransaction->due_date?->format('d M Y') ?? '—' }}</td></tr>
                    <tr><th>Total</th><td>₹{{ number_format($dealerTransaction->total_amount, 2) }}</td></tr>
                    <tr><th>Paid</th><td>₹{{ number_format($dealerTransaction->paid_amount, 2) }}</td></tr>
                    <tr><th>Due</th><td class="{{ $dealerTransaction->due_amount > 0 ? 'text-danger fw-bold' : 'text-success' }}">₹{{ number_format($dealerTransaction->due_amount, 2) }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    @if($dealerTransaction->due_amount > 0)
    <div class="col-md-4">
        <div class="card border-warning">
            <div class="card-header">Record Payment</div>
            <div class="card-body">
                <form action="{{ route('dealer-transactions.pay', $dealerTransaction) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label form-label-sm">Amount (₹)</label>
                        <input type="number" name="amount" class="form-control form-control-sm" step="0.01" min="0.01"
                               max="{{ $dealerTransaction->due_amount }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label form-label-sm">Mode</label>
                        <select name="mode" class="form-select form-select-sm">
                            <option value="cash">Cash</option>
                            <option value="upi">UPI</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Card</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label form-label-sm">Date</label>
                        <input type="date" name="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label form-label-sm">Notes</label>
                        <input type="text" name="notes" class="form-control form-control-sm">
                    </div>
                    <button class="btn btn-warning btn-sm w-100">Pay Dealer</button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Items Table -->
<h6 class="mb-2">Items in this Purchase</h6>
<div class="card mb-3">
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>IMEI</th>
                    <th>Brand / Model</th>
                    <th>Variant</th>
                    <th>Color</th>
                    <th class="text-end">Cost</th>
                    <th>Status</th>
                    <th>Return</th>
                </tr>
            </thead>
            <tbody>
                @php $colors = ['in_stock'=>'success','sold'=>'secondary','returned'=>'info','damaged'=>'danger'] @endphp
                @foreach($dealerTransaction->stockItems as $item)
                <tr>
                    <td class="font-monospace">{{ $item->imei1 }}</td>
                    <td>{{ $item->brand }} {{ $item->model }}</td>
                    <td>{{ $item->variant }}</td>
                    <td>{{ $item->color }}</td>
                    <td class="text-end">₹{{ number_format($item->cost_price, 0) }}</td>
                    <td><span class="badge bg-{{ $colors[$item->status] }}">{{ str_replace('_',' ',ucfirst($item->status)) }}</span></td>
                    <td>
                        @if($item->status === 'in_stock')
                        <form action="{{ route('dealer-transactions.return', $dealerTransaction) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Return this item to dealer?')">
                            @csrf
                            <input type="hidden" name="stock_item_ids[]" value="{{ $item->id }}">
                            <button class="btn btn-xs btn-outline-info btn-sm">Return</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Payment History -->
@if($dealerTransaction->payments->count())
<h6 class="mb-2">Payment History</h6>
<div class="card">
    <div class="table-responsive">
        <table class="table table-sm mb-0">
            <thead class="table-light">
                <tr><th>Date</th><th>Amount</th><th>Mode</th><th>Notes</th></tr>
            </thead>
            <tbody>
                @foreach($dealerTransaction->payments as $pmt)
                <tr>
                    <td>{{ $pmt->date->format('d M Y') }}</td>
                    <td>₹{{ number_format($pmt->amount, 2) }}</td>
                    <td>{{ ucfirst(str_replace('_',' ',$pmt->mode)) }}</td>
                    <td>{{ $pmt->notes ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
