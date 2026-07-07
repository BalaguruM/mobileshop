@extends('layouts.app')
@section('title', 'Stock')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-box-seam me-2"></i>Stock Inventory</h4>
    <a href="{{ route('stock.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Item</a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2" method="GET">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="IMEI / Brand / Model" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="in_stock" {{ request('status')=='in_stock'?'selected':'' }}>In Stock</option>
                    <option value="sold" {{ request('status')=='sold'?'selected':'' }}>Sold</option>
                    <option value="returned" {{ request('status')=='returned'?'selected':'' }}>Returned</option>
                    <option value="damaged" {{ request('status')=='damaged'?'selected':'' }}>Damaged</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="brand" class="form-select form-select-sm">
                    <option value="">All Brands</option>
                    @foreach($brands as $b)
                    <option value="{{ $b }}" {{ request('brand')==$b?'selected':'' }}>{{ $b }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary">Filter</button>
                <a href="{{ route('stock.index') }}" class="btn btn-sm btn-link">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>IMEI</th>
                    <th>Brand / Model</th>
                    <th>Variant</th>
                    <th>Color</th>
                    <th>Dealer</th>
                    <th class="text-end">Cost</th>
                    <th class="text-end">Selling</th>
                    <th>Status</th>
                    <th>Added</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td><small class="font-monospace">{{ $item->imei1 }}</small></td>
                    <td>{{ $item->brand }} {{ $item->model }}</td>
                    <td><small>{{ $item->variant }}</small></td>
                    <td><small>{{ $item->color }}</small></td>
                    <td><small>{{ $item->dealer->name ?? '—' }}</small></td>
                    <td class="text-end">₹{{ number_format($item->cost_price, 0) }}</td>
                    <td class="text-end">₹{{ number_format($item->selling_price, 0) }}</td>
                    <td>
                        @php $colors = ['in_stock'=>'success','sold'=>'secondary','returned'=>'info','damaged'=>'danger'] @endphp
                        <span class="badge bg-{{ $colors[$item->status] }}">{{ str_replace('_',' ',ucfirst($item->status)) }}</span>
                    </td>
                    <td><small>{{ $item->date_added->format('d M Y') }}</small></td>
                    <td>
                        <a href="{{ route('stock.show', $item) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        @if($item->status === 'in_stock')
                        <a href="{{ route('stock.edit', $item) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" class="text-center text-muted py-4">No stock items found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($items->hasPages())
    <div class="card-footer">{{ $items->links() }}</div>
    @endif
</div>
@endsection
