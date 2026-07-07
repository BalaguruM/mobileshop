@extends('layouts.app')
@section('title', 'Purchases from Dealers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-arrow-down-circle me-2"></i>Purchases from Dealers</h4>
    <a href="{{ route('dealer-transactions.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> New Purchase</a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2" method="GET">
            <div class="col-md-3">
                <select name="dealer_id" class="form-select form-select-sm">
                    <option value="">All Dealers</option>
                    @foreach($dealers as $d)
                    <option value="{{ $d->id }}" {{ request('dealer_id')==$d->id?'selected':'' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <div class="form-check mt-1">
                    <input type="checkbox" name="dues_only" value="1" class="form-check-input" id="dues_only" {{ request('dues_only')?'checked':'' }}>
                    <label class="form-check-label" for="dues_only">Pending dues only</label>
                </div>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary">Filter</button>
                <a href="{{ route('dealer-transactions.index') }}" class="btn btn-sm btn-link">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Dealer</th>
                    <th>Type</th>
                    <th class="text-end">Total</th>
                    <th class="text-end">Paid</th>
                    <th class="text-end">Due</th>
                    <th>Due Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $txn)
                <tr>
                    <td><small>#{{ $txn->id }}</small></td>
                    <td>{{ $txn->date->format('d M Y') }}</td>
                    <td><a href="{{ route('dealers.show', $txn->dealer) }}" class="text-decoration-none">{{ $txn->dealer->name }}</a></td>
                    <td><span class="badge bg-{{ $txn->type==='purchase'?'primary':'info' }}">{{ ucfirst($txn->type) }}</span></td>
                    <td class="text-end">₹{{ number_format($txn->total_amount, 0) }}</td>
                    <td class="text-end">₹{{ number_format($txn->paid_amount, 0) }}</td>
                    <td class="text-end {{ $txn->due_amount > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                        ₹{{ number_format($txn->due_amount, 0) }}
                    </td>
                    <td>
                        @if($txn->due_date)
                            <span class="{{ $txn->due_date->isPast() && $txn->due_amount > 0 ? 'text-danger' : '' }}">
                                {{ $txn->due_date->format('d M Y') }}
                            </span>
                        @else —
                        @endif
                    </td>
                    <td><a href="{{ route('dealer-transactions.show', $txn) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">No transactions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
    <div class="card-footer">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection
