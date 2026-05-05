<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = today();

        // Today's order count
        $todayOrderCount = DB::table('orders')
            ->whereDate('created_at', $today)
            ->count();

        // Total unique customers
        $totalCustomers = DB::table('customers')->count();

        // Low stock items (quantity <= 20)
        $lowStockCount = DB::table('inventory')
            ->where('quantity', '<=', 20)
            ->count();

        // Total revenue today (completed orders only)
        $totalRevenue = DB::table('orders')
            ->whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total_amount');

        // Recent orders with customer name
        $recentOrders = DB::table('orders')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select(
                'orders.id',
                DB::raw("CONCAT(customers.customer_fn, ' ', customers.customer_ln) as customer_name"),
                'orders.status',
                'orders.total_amount'
            )
            ->orderBy('orders.created_at', 'desc')
            ->limit(50)
            ->get();

        // Top products today by quantity sold
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereDate('orders.created_at', $today)
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->get();

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