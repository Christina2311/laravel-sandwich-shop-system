<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QueueController extends Controller
{
    public function index()
    {
        // Call stored procedures
        $pending   = collect(DB::select('CALL GetPendingOrders()'));
        $preparing = collect(DB::select('CALL GetPreparingOrders()'));
        $completed = collect(DB::select('CALL GetCompletedOrders()'));

        // Fetch order items with product names for each group
        $allOrderIds = $pending->pluck('id')
            ->merge($preparing->pluck('id'))
            ->merge($completed->pluck('id'))
            ->unique();

        $orderItems = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'order_items.order_id',
                'order_items.quantity',
                'products.name as product_name'
            )
            ->whereIn('order_items.order_id', $allOrderIds)
            ->get()
            ->groupBy('order_id');

        return view('baker.queue', compact('pending', 'preparing', 'completed', 'orderItems'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'in:Preparing,Ready'],
        ]);

        $updateData = ['status' => $request->status];

        if ($request->status === 'Preparing' && is_null($order->baker_id)) {
            $bakerId = Employee::where('user_id', Auth::id())->value('id');
            $updateData['baker_id'] = $bakerId;
        }

        $order->update($updateData);

        return redirect()
            ->route('baker.queue')
            ->with('success', 'Order #' . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ' updated to ' . $request->status . '.');
    }
}