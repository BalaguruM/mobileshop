@extends('layouts.app')
@section('title', $customer->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-person me-2"></i>{{ $customer->name }}</h4>
    <div>
        <a href="{{ route('sales.create') }}?customer_id={{ $customer->id }}" class="btn btn-success btn-sm">
            <i class="bi bi-cart-plus"></i> New Sale
        </a>
        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted mb-3">Contact Info</h6>
                <p class="mb-1"><i class="bi bi-phone me-2"></i>{{ $customer->phone ?? 'N/A' }}</p>
                <p class="mb-1"><i class="bi bi-geo-alt me-2"></i>{{ $customer->address ?? 'N/A' }}</p>
                <p class="mb-1"><i class="bi bi-card-text me-2"></i>{{ $customer->id_proof ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-{{ $customer->total_due > 0 ? 'danger' : 'success' }}">
            <div class="card-body text-center">
                <p class="text-muted mb-1">Outstanding Due</p>
                <h2 class="{{ $customer->total_due > 0 ? 'text-danger' : 'text-success' }}">
                    ₹{{ number_format($customer->total_due, 2) }}
                </h2>
            </div>
        </div>
    </div>
</div>

<h6 class="mb-2">Purchase History</h6>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Mode</th>
                    <th class="text-end">Total</th>
                    <th class="text-end">Paid</th>
                    <th class="text-end">Due</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $sale)
                <tr>
                    <td>{{ $sale->date->format('d M Y') }}</td>
                    <td>{{ $sale->saleItems->count() }} unit(s)</td>
                    <td><span class="badge bg-secondary">{{ ucfirst($sale->payment_mode) }}</span></td>
                    <td class="text-end">₹{{ number_format($sale->total_amount, 0) }}</td>
                    <td class="text-end">₹{{ number_format($sale->paid_amount, 0) }}</td>
                    <td class="text-end {{ $sale->due_amount > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                        ₹{{ number_format($sale->due_amount, 0) }}
                    </td>
                    <td><a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-3">No purchases yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
    <div class="card-footer">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection
