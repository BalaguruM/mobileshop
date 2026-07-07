@extends('layouts.app')
@section('title', 'Sales')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-cart-check me-2"></i>Sales</h4>
    <a href="{{ route('sales.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> New Sale</a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2" method="GET">
            <div class="col-md-3">
                <select name="customer_id" class="form-select form-select-sm">
                    <option value="">All Customers</option>
                    @foreach($customers as $c)
                    <option value="{{ $c->id }}" {{ request('customer_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}" placeholder="From">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}" placeholder="To">
            </div>
            <div class="col-auto">
                <div class="form-check mt-1">
                    <input type="checkbox" name="dues_only" value="1" class="form-check-input" id="dues_only" {{ request('dues_only')?'checked':'' }}>
                    <label class="form-check-label" for="dues_only">Pending dues</label>
                </div>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary">Filter</button>
                <a href="{{ route('sales.index') }}" class="btn btn-sm btn-link">Clear</a>
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
                    <th>Customer</th>
                    <th>Mode</th>
                    <th class="text-end">Total</th>
                    <th class="text-end">Paid</th>
                    <th class="text-end">Due</th>
                    <th>Due Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td><small>#{{ $sale->id }}</small></td>
                    <td>{{ $sale->date->format('d M Y') }}</td>
                    <td>{{ $sale->customer_label }}</td>
                    <td><span class="badge bg-secondary">{{ ucfirst($sale->payment_mode) }}</span></td>
                    <td class="text-end">₹{{ number_format($sale->total_amount, 0) }}</td>
                    <td class="text-end">₹{{ number_format($sale->paid_amount, 0) }}</td>
                    <td class="text-end {{ $sale->due_amount > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                        ₹{{ number_format($sale->due_amount, 0) }}
                    </td>
                    <td>
                        @if($sale->due_date)
                            <span class="{{ $sale->due_date->isPast() && $sale->due_amount > 0 ? 'text-danger' : '' }}">
                                {{ $sale->due_date->format('d M Y') }}
                            </span>
                        @else —
                        @endif
                    </td>
                    <td><a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">No sales found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($sales->hasPages())
    <div class="card-footer">{{ $sales->links() }}</div>
    @endif
</div>
@endsection
