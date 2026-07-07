<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DealerTransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleTransactionController;
use App\Http\Controllers\StockItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('dealers', DealerController::class);
Route::resource('customers', CustomerController::class);
Route::resource('stock', StockItemController::class);

Route::resource('dealer-transactions', DealerTransactionController::class)
    ->only(['index', 'create', 'store', 'show']);
Route::post('dealer-transactions/{dealerTransaction}/pay', [DealerTransactionController::class, 'pay'])
    ->name('dealer-transactions.pay');
Route::post('dealer-transactions/{dealerTransaction}/return', [DealerTransactionController::class, 'returnItems'])
    ->name('dealer-transactions.return');

Route::resource('sales', SaleTransactionController::class)
    ->only(['index', 'create', 'store', 'show']);
Route::post('sales/{sale}/pay', [SaleTransactionController::class, 'pay'])
    ->name('sales.pay');

Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
