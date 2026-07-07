@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
    <span class="text-muted">{{ now()->format('d M Y') }}</span>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card border-primary h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">In Stock</p>
                        <h3 class="mb-0 text-primary">{{ $stats['total_stock'] }}</h3>
                    </div>
                    <i class="bi bi-box-seam text-primary fs-2 opacity-50"></i>
                </div>
                <small class="text-muted">Stock value: ₹{{ number_format($stats['stock_value'], 0) }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Today Sales</p>
                        <h3 class="mb-0 text-success">₹{{ number_format($stats['today_sales'], 0) }}</h3>
                    </div>
                    <i class="bi bi-cart-check text-success fs-2 opacity-50"></i>
                </div>
                <small class="text-muted">{{ $stats['today_sales_count'] }} transactions</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-warning h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Customer Dues</p>
                        <h3 class="mb-0 text-warning">₹{{ number_format($stats['customer_dues'], 0) }}</h3>
                    </div>
                    <i class="bi bi-person-exclamation text-warning fs-2 opacity-50"></i>
                </div>
                <small class="text-muted">Receivables</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-danger h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Dealer Dues</p>
                        <h3 class="mb-0 text-danger">₹{{ number_format($stats['dealer_dues'], 0) }}</h3>
                    </div>
                    <i class="bi bi-building-exclamation text-danger fs-2 opacity-50"></i>
                </div>
                <small class="text-muted">Payables</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Recent Sales -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span><i class="bi bi-cart me-2"></i>Recent Sales</span>
                <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <tbody>
                        @forelse($recent_sales as $sale)
                        <tr>
                            <td class="ps-3">
                                <div>{{ $sale->customer_label }}</div>
                                <small class="text-muted">{{ $sale->date->format('d M') }}</small>
                            </td>
                            <td class="text-end pe-3">
                                <div>₹{{ number_format($sale->total_amount, 0) }}</div>
                                @if($sale->due_amount > 0)
                                    <span class="badge bg-warning text-dark">Due: ₹{{ number_format($sale->due_amount, 0) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center text-muted py-3">No sales yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Customer Dues -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span><i class="bi bi-people me-2"></i>Top Customer Dues</span>
                <a href="{{ route('customers.index', ['dues_only' => 1]) }}" class="btn btn-sm btn-outline-warning">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                        @forelse($overdue_customers as $c)
                        <tr>
                            <td class="ps-3">
                                <a href="{{ route('customers.show', $c) }}" class="text-decoration-none">{{ $c->name }}</a>
                                <div><small class="text-muted">{{ $c->phone }}</small></div>
                            </td>
                            <td class="text-end pe-3 text-danger fw-bold">₹{{ number_format($c->total_due, 0) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center text-muted py-3">No pending dues</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Low Stock -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-header"><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Low Stock Alert</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                        @forelse($low_stock_models as $m)
                        <tr>
                            <td class="ps-3">
                                <div class="small">{{ $m->brand }} {{ $m->model }}</div>
                            </td>
                            <td class="text-end pe-3">
                                <span class="badge {{ $m->count == 0 ? 'bg-danger' : 'bg-warning text-dark' }}">{{ $m->count }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center text-muted py-3">Stock levels OK</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
