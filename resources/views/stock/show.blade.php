@extends('layouts.app')
@section('title', 'Stock Item')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">{{ $stock->brand }} {{ $stock->model }}</h4>
    <div>
        @if($stock->status === 'in_stock')
        <a href="{{ route('stock.edit', $stock) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
        @endif
        <a href="{{ route('stock.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">Device Details</div>
            <div class="card-body">
                @php $colors = ['in_stock'=>'success','sold'=>'secondary','returned'=>'info','damaged'=>'danger'] @endphp
                <table class="table table-sm mb-0">
                    <tr><th>Status</th><td><span class="badge bg-{{ $colors[$stock->status] }}">{{ str_replace('_',' ',ucfirst($stock->status)) }}</span></td></tr>
                    <tr><th>IMEI 1</th><td class="font-monospace">{{ $stock->imei1 }}</td></tr>
                    @if($stock->imei2)<tr><th>IMEI 2</th><td class="font-monospace">{{ $stock->imei2 }}</td></tr>@endif
                    <tr><th>Brand</th><td>{{ $stock->brand }}</td></tr>
                    <tr><th>Model</th><td>{{ $stock->model }}</td></tr>
                    <tr><th>Variant</th><td>{{ $stock->variant ?? '—' }}</td></tr>
                    <tr><th>Color</th><td>{{ $stock->color ?? '—' }}</td></tr>
                    <tr><th>Cost Price</th><td>₹{{ number_format($stock->cost_price, 2) }}</td></tr>
                    <tr><th>Selling Price</th><td>₹{{ number_format($stock->selling_price, 2) }}</td></tr>
                    <tr><th>Date Added</th><td>{{ $stock->date_added->format('d M Y') }}</td></tr>
                    <tr><th>Warranty</th><td>{{ $stock->warranty_period ?? '—' }}</td></tr>
                    <tr><th>Box Contents</th><td>{{ $stock->box_contents ?? '—' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">Source</div>
            <div class="card-body">
                @if($stock->dealer)
                <p class="mb-1"><strong>Dealer:</strong>
                    <a href="{{ route('dealers.show', $stock->dealer) }}">{{ $stock->dealer->name }}</a>
                </p>
                @endif
                @if($stock->dealerTransaction)
                <p class="mb-1"><strong>Purchase Txn:</strong>
                    <a href="{{ route('dealer-transactions.show', $stock->dealerTransaction) }}">#{{ $stock->dealerTransaction->id }}</a>
                </p>
                @endif
            </div>
        </div>
        @if($stock->saleItem)
        <div class="card">
            <div class="card-header">Sale Info</div>
            <div class="card-body">
                @php $saleTxn = $stock->saleItem->saleTransaction @endphp
                <p class="mb-1"><strong>Sale #{{ $saleTxn->id }}</strong></p>
                <p class="mb-1">Customer: {{ $saleTxn->customer_label }}</p>
                <p class="mb-1">Date: {{ $saleTxn->date->format('d M Y') }}</p>
                <p class="mb-1">Sold for: ₹{{ number_format($stock->saleItem->selling_price, 2) }}</p>
                <a href="{{ route('sales.show', $saleTxn) }}" class="btn btn-sm btn-outline-primary mt-1">View Sale</a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
