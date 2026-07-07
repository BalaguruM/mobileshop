@extends('layouts.app')
@section('title', 'Customers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-people me-2"></i>Customers</h4>
    <a href="{{ route('customers.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Customer</a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2" method="GET">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search name or phone" value="{{ request('search') }}">
            </div>
            <div class="col-auto">
                <div class="form-check mt-1">
                    <input type="checkbox" name="dues_only" value="1" class="form-check-input" id="dues_only" {{ request('dues_only') ? 'checked' : '' }}>
                    <label class="form-check-label" for="dues_only">Dues only</label>
                </div>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary">Filter</button>
                <a href="{{ route('customers.index') }}" class="btn btn-sm btn-link">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>ID Proof</th>
                    <th class="text-end">Total Due (₹)</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td><a href="{{ route('customers.show', $customer) }}" class="text-decoration-none fw-semibold">{{ $customer->name }}</a></td>
                    <td>{{ $customer->phone ?? '—' }}</td>
                    <td><small>{{ $customer->id_proof ?? '—' }}</small></td>
                    <td class="text-end {{ $customer->total_due > 0 ? 'text-danger fw-bold' : '' }}">
                        {{ number_format($customer->total_due, 2) }}
                    </td>
                    <td class="text-end">
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this customer?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No customers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
    <div class="card-footer">{{ $customers->links() }}</div>
    @endif
</div>
@endsection
