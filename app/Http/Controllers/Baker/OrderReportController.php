<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderReportController extends Controller
{
    public function index()
    {
        $orders = DB::table('orders')
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('employees as seller', 'orders.seller_id', '=', 'seller.id')  // ← added
            ->leftJoin('employees as baker',  'orders.baker_id',  '=', 'baker.id')
            ->select(
                'orders.id',
                'orders.status',
                'orders.subtotal',
                'orders.tax',
                'orders.total_amount',
                'orders.seller_id',
                'orders.baker_id',
                'orders.created_at',
                DB::raw("CONCAT(customers.customer_fn, ' ', customers.customer_ln) as customer_name"),
                DB::raw("CONCAT(seller.employee_fn, ' ', seller.employee_ln) as seller_name"),   // ← added
                DB::raw("CONCAT(baker.employee_fn,  ' ', baker.employee_ln)  as baker_name")
            )
            ->orderBy('orders.created_at', 'desc')
            ->paginate(15);

        return view('baker.orderreports.index', compact('orders'));
    }

    public function show($id)
    {
        $order = DB::table('orders')
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('employees as baker',  'orders.baker_id',  '=', 'baker.id')
            ->leftJoin('employees as seller', 'orders.seller_id', '=', 'seller.id')
            ->select(
                'orders.id',
                'orders.status',
                'orders.subtotal',
                'orders.tax',
                'orders.total_amount',
                'orders.seller_id',
                'orders.baker_id',
                'orders.created_at',
                DB::raw("CONCAT(customers.customer_fn, ' ', customers.customer_ln) as customer_name"),
                'customers.phone as customer_phone',
                'customers.email as customer_email',
                DB::raw("CONCAT(baker.employee_fn,  ' ', baker.employee_ln)  as baker_name"),
                DB::raw("CONCAT(seller.employee_fn, ' ', seller.employee_ln) as seller_name")
            )
            ->where('orders.id', $id)
            ->first();

        if (!$order) {
            abort(404);
        }

        $items = DB::table('order_items')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'order_items.id',
                'order_items.quantity',
                'order_items.unit_price',
                DB::raw("IFNULL(products.name, 'Unknown Product') as product_name"),
                'products.category',
                DB::raw('order_items.quantity * order_items.unit_price as line_total')
            )
            ->where('order_items.order_id', $id)
            ->get();

        return view('baker.orderreports.show', compact('order', 'items'));
    }
}