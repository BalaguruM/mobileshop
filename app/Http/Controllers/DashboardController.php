<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Dealer;
use App\Models\SaleTransaction;
use App\Models\StockItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $stats = [
            'total_stock'       => StockItem::where('status', 'in_stock')->count(),
            'total_sold'        => StockItem::where('status', 'sold')->count(),
            'customer_dues'     => Customer::sum('total_due'),
            'dealer_dues'       => Dealer::sum('total_due'),
            'today_sales'       => SaleTransaction::whereDate('date', $today)->sum('total_amount'),
            'today_sales_count' => SaleTransaction::whereDate('date', $today)->count(),
            'month_sales'       => SaleTransaction::whereMonth('date', $today->month)
                ->whereYear('date', $today->year)->sum('total_amount'),
        ];

        $stock_value = StockItem::where('status', 'in_stock')->sum('cost_price');
        $stats['stock_value'] = $stock_value;

        $overdue_customers = Customer::where('total_due', '>', 0)->orderByDesc('total_due')->take(5)->get();
        $overdue_dealers   = Dealer::where('total_due', '>', 0)->orderByDesc('total_due')->take(5)->get();

        $recent_sales = SaleTransaction::with('customer')->latest()->take(5)->get();

        $top_brands = StockItem::where('status', 'sold')
            ->select('brand', DB::raw('count(*) as count'))
            ->groupBy('brand')->orderByDesc('count')->take(5)->get();

        $low_stock_models = StockItem::where('status', 'in_stock')
            ->select('brand', 'model', DB::raw('count(*) as count'))
            ->groupBy('brand', 'model')->having('count', '<', 3)
            ->orderBy('count')->take(10)->get();

        return view('dashboard', compact(
            'stats', 'overdue_customers', 'overdue_dealers',
            'recent_sales', 'top_brands', 'low_stock_models'
        ));
    }
}
