<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Call GetDashboardStats procedure ───────────────────────────────
        // Returns today_order_count, total_customers,
        //         low_stock_count, total_revenue_today  in one query.
        $stats = DB::select('CALL GetDashboardStats()')[0];

        $todayOrderCount = $stats->today_order_count;
        $totalCustomers  = $stats->total_customers;
        $lowStockCount   = $stats->low_stock_count;
        $totalRevenue    = $stats->total_revenue_today;

        // ── Call GetRecentOrders procedure ─────────────────────────────────
        // Returns last 50 orders with customer_name (Walk-in included).
        $recentOrders = collect(DB::select('CALL GetRecentOrders()'));

        // ── Call GetTopProductsToday procedure ─────────────────────────────
        // Returns top-selling products for today ranked by qty sold.
        $topProducts = collect(DB::select('CALL GetTopProductsToday()'));

        return view('seller.dashboard.index', compact(
            'todayOrderCount',
            'totalCustomers',
            'lowStockCount',
            'totalRevenue',
            'recentOrders',
            'topProducts'
        ));
    }
}