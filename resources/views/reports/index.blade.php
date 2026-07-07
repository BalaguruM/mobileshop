@extends('layouts.app')
@section('title', 'Reports')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Reports</h4>
</div>

<!-- Period Filter -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2" method="GET">
            <div class="col-auto">
                @foreach(['today'=>'Today','week'=>'This Week','month'=>'This Month','year'=>'This Year'] as $key => $label)
                <a href="{{ route('reports.index', ['period'=>$key]) }}"
                   class="btn btn-sm {{ $period==$key ? 'btn-primary' : 'btn-outline-secondary' }} me-1">
                    {{ $label }}
                </a>
                @endforeach
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control form-control-sm" value="{{ $dateFrom->format('Y-m-d') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control form-control-sm" value="{{ $dateTo->format('Y-m-d') }}">
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary">Custom Range</button>
            </div>
        </form>
    </div>
</div>

<!-- Sales Summary -->
<div class="row g-3 mb-4">
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <p class="text-muted small mb-1">Sales Count</p>
                <h3>{{ $salesSummary['count'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <p class="text-muted small mb-1">Revenue</p>
                <h4 class="text-success">₹{{ number_format($salesSummary['revenue'], 0) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <p class="text-muted small mb-1">Cost</p>
                <h4 class="text-danger">₹{{ number_format($salesSummary['cost'], 0) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border-success">
            <div class="card-body">
                <p class="text-muted small mb-1">Profit</p>
                <h4 class="text-success fw-bold">₹{{ number_format($salesSummary['profit'], 0) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <p class="text-muted small mb-1">Collected</p>
                <h4>₹{{ number_format($salesSummary['collected'], 0) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border-warning">
            <div class="card-body">
                <p class="text-muted small mb-1">Pending</p>
                <h4 class="text-warning">₹{{ number_format($salesSummary['pending'], 0) }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Top Models -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">Top Selling Models</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>Brand / Model</th><th class="text-end">Qty</th><th class="text-end">Revenue</th></tr>
                    </thead>
                    <tbody>
                        @forelse($topModels as $m)
                        <tr>
                            <td>{{ $m->brand }} {{ $m->model }}</td>
                            <td class="text-end">{{ $m->count }}</td>
                            <td class="text-end">₹{{ number_format($m->revenue, 0) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-2">No data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Stock -->
    <div class="col-md-3">
        <div class="card mb-3">
            <div class="card-header">Current Stock</div>
            <div class="card-body text-center">
                <h2 class="text-primary">{{ $stockCount }}</h2>
                <p class="text-muted mb-0">Units in stock</p>
                <h4 class="mt-2">₹{{ number_format($stockValue, 0) }}</h4>
                <p class="text-muted mb-0 small">Total stock value</p>
            </div>
        </div>
    </div>

    <!-- Dues Summary -->
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">Customer Dues (Top 5)</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                        @forelse($customerDues->take(5) as $c)
                        <tr>
                            <td class="ps-3">
                                <a href="{{ route('customers.show', $c) }}" class="text-decoration-none">{{ $c->name }}</a>
                            </td>
                            <td class="text-end pe-3 text-danger">₹{{ number_format($c->total_due, 0) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center text-muted py-2">No pending dues</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Dealer Dues (Top 5)</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                        @forelse($dealerDues->take(5) as $d)
                        <tr>
                            <td class="ps-3">
                                <a href="{{ route('dealers.show', $d) }}" class="text-decoration-none">{{ $d->name }}</a>
                            </td>
                            <td class="text-end pe-3 text-warning">₹{{ number_format($d->total_due, 0) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center text-muted py-2">No pending dues</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
