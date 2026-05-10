<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // ── Date Range from filters (defaults to current month) ───────
        $activeFilter = request('filter', 'monthly');
        $dateFrom     = request('from',   $now->copy()->startOfMonth()->toDateString());
        $dateTo       = request('to',     $now->copy()->endOfMonth()->toDateString());

        $start = Carbon::parse($dateFrom)->startOfDay();
        $end   = Carbon::parse($dateTo)->endOfDay();

        // For summary cards always use current month
        $startOfMonth   = $now->copy()->startOfMonth();
        $endOfMonth     = $now->copy()->endOfMonth();
        $startLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endLastMonth   = $now->copy()->subMonth()->endOfMonth();

        // ── Top Selling Products ──────────────────────────────────────
        $topProducts = DB::table('order_items')
            ->join('orders',   'order_items.order_id',   '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_items.quantity)                          AS total_qty'),
                DB::raw('SUM(order_items.quantity * order_items.unit_price) AS total_revenue')
            )
            ->get();

        // ── Revenue Summary (this month) ──────────────────────────────
        $summary = DB::table('orders')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->selectRaw('COUNT(*) AS total_orders, COALESCE(SUM(total_amount), 0) AS total_revenue')
            ->first();

        $totalRevenue = $summary->total_revenue ?? 0;
        $totalOrders  = $summary->total_orders  ?? 0;

        // ── Revenue Summary (last month, for change indicators) ───────
        $lastSummary = DB::table('orders')
            ->whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->selectRaw('COUNT(*) AS total_orders, COALESCE(SUM(total_amount), 0) AS total_revenue')
            ->first();

        $lastRevenue = $lastSummary->total_revenue ?? 0;
        $lastOrders  = $lastSummary->total_orders  ?? 0;

        // % change in revenue vs last month
        $revenueChange = $lastRevenue > 0
            ? round((($totalRevenue - $lastRevenue) / $lastRevenue) * 100, 1)
            : 0;

        // absolute change in orders vs last month
        $ordersChange = $totalOrders - $lastOrders;

        // avg order value change vs last month
        $avgThis = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $avgLast = $lastOrders  > 0 ? $lastRevenue  / $lastOrders  : 0;
        $avgChange = round($avgThis - $avgLast, 2);

        // ── Daily Sales (filtered date range) ────────────────────────
        $dailySales = DB::table('orders')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) AS sale_date, COUNT(*) AS orders, COALESCE(SUM(total_amount), 0) AS total_sales')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('sale_date')
            ->get();

        // ── Inventory Status ──────────────────────────────────────────
        $inventoryItems = DB::table('inventory')
            ->join('products', 'inventory.product_id', '=', 'products.id')
            ->select(
                'inventory.id',
                'products.name',
                'inventory.quantity',
                'inventory.unit',
                'inventory.status'
            )
            ->orderBy('products.name')
            ->get();

        $lowStockCount   = $inventoryItems->filter(fn($i) => $i->status === 'Low Stock')->count();
        $totalStockValue = 0; // no unit_cost column in inventory table

        return view('manager.reports.index', [
            'topProducts'    => $topProducts,
            'totalRevenue'   => $totalRevenue,
            'totalOrders'    => $totalOrders,
            'revenueChange'  => $revenueChange,
            'ordersChange'   => $ordersChange,
            'avgChange'      => $avgChange,
            'dailySales'     => $dailySales,
            'inventoryItems' => $inventoryItems,
            'lowStockCount'  => $lowStockCount,
            'totalStockValue'=> $totalStockValue,
            'dateFrom'       => $dateFrom,
            'dateTo'         => $dateTo,
            'activeFilter'   => $activeFilter,
        ]);
    }
}