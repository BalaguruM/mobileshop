<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Dealer;
use App\Models\SaleItem;
use App\Models\SaleTransaction;
use App\Models\StockItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period    = $request->get('period', 'month');
        $dateFrom  = $request->filled('date_from') ? Carbon::parse($request->date_from) : null;
        $dateTo    = $request->filled('date_to')   ? Carbon::parse($request->date_to)   : null;

        if (!$dateFrom) {
            $dateFrom = match($period) {
                'today'  => Carbon::today(),
                'week'   => Carbon::now()->startOfWeek(),
                'month'  => Carbon::now()->startOfMonth(),
                'year'   => Carbon::now()->startOfYear(),
                default  => Carbon::now()->startOfMonth(),
            };
            $dateTo = Carbon::now();
        }

        $salesQuery = SaleTransaction::whereBetween('date', [$dateFrom, $dateTo]);

        $salesSummary = [
            'count'        => $salesQuery->count(),
            'total'        => $salesQuery->sum('total_amount'),
            'collected'    => $salesQuery->sum('paid_amount'),
            'pending'      => $salesQuery->sum('due_amount'),
        ];

        // Profit calculation
        $soldItems = SaleItem::with('stockItem')
            ->whereHas('saleTransaction', fn($q) => $q->whereBetween('date', [$dateFrom, $dateTo]))
            ->get();
        $salesSummary['revenue']  = $soldItems->sum('selling_price');
        $salesSummary['cost']     = $soldItems->sum(fn($i) => $i->stockItem->cost_price ?? 0);
        $salesSummary['profit']   = $salesSummary['revenue'] - $salesSummary['cost'];

        $topBrands = StockItem::where('status', 'sold')
            ->whereBetween('updated_at', [$dateFrom, $dateTo])
            ->select('brand', DB::raw('count(*) as count'))
            ->groupBy('brand')->orderByDesc('count')->take(10)->get();

        $topModels = StockItem::where('status', 'sold')
            ->whereBetween('updated_at', [$dateFrom, $dateTo])
            ->select('brand', 'model', DB::raw('count(*) as count'), DB::raw('sum(selling_price) as revenue'))
            ->groupBy('brand', 'model')->orderByDesc('count')->take(10)->get();

        $customerDues = Customer::where('total_due', '>', 0)->orderByDesc('total_due')->get();
        $dealerDues   = Dealer::where('total_due', '>', 0)->orderByDesc('total_due')->get();

        $stockValue = StockItem::where('status', 'in_stock')->sum('cost_price');
        $stockCount = StockItem::where('status', 'in_stock')->count();

        return view('reports.index', compact(
            'salesSummary', 'topBrands', 'topModels',
            'customerDues', 'dealerDues',
            'stockValue', 'stockCount',
            'period', 'dateFrom', 'dateTo'
        ));
    }
}
