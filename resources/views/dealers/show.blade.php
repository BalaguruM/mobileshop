@extends('layouts.app')
@section('title', $dealer->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-building me-2"></i>{{ $dealer->name }}</h4>
    <div>
        <a href="{{ route('dealer-transactions.create') }}?dealer_id={{ $dealer->id }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus"></i> New Purchase
        </a>
        <a href="{{ route('dealers.edit', $dealer) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
        <a href="{{ route('dealers.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted mb-3">Dealer Info</h6>
                <p class="mb-1"><i class="bi bi-phone me-2"></i>{{ $dealer->phone ?? 'N/A' }}</p>
                <p class="mb-1"><i class="bi bi-geo-alt me-2"></i>{{ $dealer->address ?? 'N/A' }}</p>
                <p class="mb-1"><i class="bi bi-file-text me-2"></i>GST: {{ $dealer->gst_number ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-{{ $dealer->total_due > 0 ? 'danger' : 'success' }}">
            <div class="card-body text-center">
                <p class="text-muted mb-1">Outstanding Balance</p>
                <h2 class="{{ $dealer->total_due > 0 ? 'text-danger' : 'text-success' }}">
                    ₹{{ number_format($dealer->total_due, 2) }}
                </h2>
                <small class="text-muted">Amount owed to dealer</small>
            </div>
        </div>
    </div>
</div>

<h6 class="mb-2">Transaction History</h6>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Items</th>
                    <th class="text-end">Total</th>
                    <th class="text-end">Paid</th>
                    <th class="text-end">Due</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $txn)
                <tr>
                    <td>{{ $txn->date->format('d M Y') }}</td>
                    <td><span class="badge bg-{{ $txn->type === 'purchase' ? 'primary' : 'info' }}">{{ ucfirst($txn->type) }}</span></td>
                    <td>{{ $txn->stockItems->count() }} units</td>
                    <td class="text-end">₹{{ number_format($txn->total_amount, 0) }}</td>
                    <td class="text-end">₹{{ number_format($txn->paid_amount, 0) }}</td>
                    <td class="text-end {{ $txn->due_amount > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                        ₹{{ number_format($txn->due_amount, 0) }}
                    </td>
                    <td><a href="{{ route('dealer-transactions.show', $txn) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-3">No transactions yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
    <div class="card-footer">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection
