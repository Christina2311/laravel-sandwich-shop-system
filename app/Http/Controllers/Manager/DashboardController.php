<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // ── Monthly Revenue (uses `total` column) ─────────────────────
        $monthlyRevenue = DB::table('orders')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('total_amount') ?? 0;

        // ── Pending Orders (status is capitalised in your DB) ─────────
        $pendingOrders = DB::table('orders')
            ->where('status', 'Pending')
            ->count();

        // ── Low Stock Items ───────────────────────────────────────────
        // Net stock per product = total stocked in − total stocked out
        // Flag products whose net stock is 10 or below
        $lowStockItems = DB::table('products')
            ->where('is_active', 1)
            ->get()
            ->filter(function ($product) {
                $in  = DB::table('stock_ins')
                    ->where('product_id', $product->id)
                    ->sum('quantity');
                $out = DB::table('stock_outs')
                    ->where('product_id', $product->id)
                    ->sum('quantity');
                return ($in - $out) <= 10;
            })
            ->count();

        // ── Active Staff (users with seller or baker role) ────────────
        $activeStaff = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles',     'role_user.role_id', '=', 'roles.id')
            ->whereIn('roles.role_name', ['seller', 'baker'])
            ->distinct('users.id')
            ->count('users.id');

        // ── Weekly Revenue Chart ──────────────────────────────────────
        $monthStart    = $now->copy()->startOfMonth();
        $weeklyLabels  = [];
        $weeklyValues  = [];
        $isCurrentWeek = [];

        for ($w = 0; $w < 4; $w++) {
            $start = $monthStart->copy()->addDays($w * 7);
            $end   = $start->copy()->addDays(6)->endOfDay();

            $weeklyLabels[]  = $start->format('M j') . '–' . $end->format('j');
            $weeklyValues[]  = (float) DB::table('orders')
                ->whereBetween('created_at', [
                    $start->startOfDay()->toDateTimeString(),
                    $end->toDateTimeString(),
                ])
                ->sum('total_amount');
            $isCurrentWeek[] = $now->between($start, $end);
        }

        // ── Staff Performance Today ───────────────────────────────────
        $sellers = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles',     'role_user.role_id', '=', 'roles.id')
            ->where('roles.role_name', 'seller')
            ->select(
                'users.id',
                'users.name',
                DB::raw("'seller' as role"),
                DB::raw('(
                    SELECT COUNT(*) FROM orders
                    WHERE orders.seller_id = users.id
                    AND DATE(orders.created_at) = CURDATE()
                ) as total_orders'),
                DB::raw('0 as total_baked')
            )
            ->get();

        $bakers = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles',     'role_user.role_id', '=', 'roles.id')
            ->where('roles.role_name', 'baker')
            ->select(
                'users.id',
                'users.name',
                DB::raw("'baker' as role"),
                DB::raw('0 as total_orders'),
                DB::raw('(
                    SELECT COUNT(*) FROM orders
                    WHERE orders.baker_id = users.id
                    AND DATE(orders.created_at) = CURDATE()
                ) as total_baked')
            )
            ->get();

        // Merge and sort by activity (baked + orders) descending
        $staffPerformance = $sellers->merge($bakers)
            ->sortByDesc(fn($s) => $s->total_orders + $s->total_baked)
            ->values();

        $pendingStockRequests = \App\Models\StockInRequest::where('status', 'pending')->count();

        return view('manager.dashboard', compact(
            'monthlyRevenue',
            'pendingOrders',
            'lowStockItems',
            'activeStaff',
            'weeklyLabels',
            'weeklyValues',
            'isCurrentWeek',
            'staffPerformance'
        ));
    }
}