@extends('layouts.app')
@section('title', 'Dealers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-building me-2"></i>Dealers</h4>
    <a href="{{ route('dealers.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Dealer</a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2" method="GET">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name or phone" value="{{ request('search') }}">
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary">Search</button>
                <a href="{{ route('dealers.index') }}" class="btn btn-sm btn-link">Clear</a>
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
                    <th>GST</th>
                    <th class="text-end">Total Due (₹)</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($dealers as $dealer)
                <tr>
                    <td><a href="{{ route('dealers.show', $dealer) }}" class="text-decoration-none fw-semibold">{{ $dealer->name }}</a></td>
                    <td>{{ $dealer->phone ?? '—' }}</td>
                    <td><small>{{ $dealer->gst_number ?? '—' }}</small></td>
                    <td class="text-end {{ $dealer->total_due > 0 ? 'text-danger fw-bold' : '' }}">
                        {{ number_format($dealer->total_due, 2) }}
                    </td>
                    <td><span class="badge {{ $dealer->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $dealer->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('dealers.edit', $dealer) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('dealers.destroy', $dealer) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this dealer?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No dealers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($dealers->hasPages())
    <div class="card-footer">{{ $dealers->links() }}</div>
    @endif
</div>
@endsection
