<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewOrderController extends Controller
{
    /**
     * Show the New Order form.
     * Passes all active products to the view.
     */
    public function index()
    {
        $products = Product::where('is_active', true)
            ->where('category', 'Sandwich')
            ->orderBy('name')
            ->get(['id', 'name', 'price', 'category']);

        return view('seller.neworder.index', compact('products'));
    }

    /**
     * Store a newly created order and its items.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_fn'        => 'nullable|string|max:255',
            'customer_ln'        => 'nullable|string|max:255',
            'phone'              => 'nullable|string|max:20',
            'email'              => 'nullable|email|max:255',
            'address'            => 'nullable|string|max:500',
            'order_date'         => 'required|date',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {

            // ── 1. Resolve or create the Customer ─────────────────────────
            $customer = null;

            $fn    = filled($request->customer_fn) ? trim($request->customer_fn) : null;
            $ln    = filled($request->customer_ln) ? trim($request->customer_ln) : null;
            $phone = filled($request->phone)        ? trim($request->phone)       : null;
            $email = filled($request->email)        ? trim($request->email)       : null;
            $addr  = filled($request->address)      ? trim($request->address)     : null;

            if ($fn !== null) {
                $customer = Customer::firstOrCreate(
                    [
                        'customer_fn' => $fn,
                        'customer_ln' => $ln ?? '',
                    ],
                    [
                        'phone'   => $phone,
                        'email'   => $email,
                        'address' => $addr,
                    ]
                );
            }

            // ── 2. Resolve seller_id from the logged-in user ───────────────
            // Looks up the employee record linked to the currently logged-in user.
            $sellerId = Employee::where('user_id', Auth::id())->value('id');

            // ── 3. Calculate totals ────────────────────────────────────────
            $productIds = collect($request->items)->pluck('product_id')->unique();
            $products   = Product::whereIn('id', $productIds)->get()->keyBy('id');

            $subtotal = 0;
            foreach ($request->items as $item) {
                $price     = $products[$item['product_id']]->price ?? 0;
                $subtotal += $price * $item['quantity'];
            }

            $taxRate     = 0.12;
            $tax         = round($subtotal * $taxRate, 2);
            $totalAmount = round($subtotal + $tax, 2);

            // ── 4. Create the Order ────────────────────────────────────────
            $order = Order::create([
                'customer_id'  => $customer?->id,
                'seller_id'    => $sellerId,   // ← now correctly set
                'baker_id'     => null,         // assigned when baker starts the order
                'status'       => 'Pending',
                'subtotal'     => $subtotal,
                'tax'          => $tax,
                'total_amount' => $totalAmount,
            ]);

            // ── 5. Create Order Items ──────────────────────────────────────
            foreach ($request->items as $item) {
                $price = $products[$item['product_id']]->price ?? 0;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'unit_price' => $price,
                    'subtotal'   => round($price * $item['quantity'], 2),
                ]);
            }
        });

        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Order placed successfully and sent to baker queue.');
    }
}