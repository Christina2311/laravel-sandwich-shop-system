<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        // Products joined with inventory for qty/unit
        // and with the last employee who updated it
        $products = DB::table('products')
            ->leftJoin('inventory', 'products.id', '=', 'inventory.product_id')
            ->leftJoin('employees', function($join) {
                // join to the employee who last did a stock_in for this product
                $join->on('employees.id', '=', DB::raw(
                    '(SELECT employee_id FROM stock_ins WHERE product_id = products.id ORDER BY created_at DESC LIMIT 1)'
                ));
            })
            ->select(
                'products.id',
                'products.name',
                'products.description',
                'products.price',
                'products.category',
                'products.is_active',
                'products.updated_at',
                'inventory.quantity as inventory_qty',
                'inventory.unit as inventory_unit',
                DB::raw("CONCAT(employees.employee_fn, ' ', employees.employee_ln) as managed_by")
            )
            ->orderBy('products.id')
            ->get();

        $activeCount = $products->where('is_active', 1)->count();
        $categories  = $products->pluck('category')->unique()->filter()->values()->toArray();

        return view('baker.products.index', compact('products', 'activeCount', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
        ]);

        $productId = DB::table('products')->insertGetId([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'category'    => $request->category,
            'is_active'   => $request->is_active ?? 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Create inventory record for new product
        DB::table('inventory')->insert([
            'product_id' => $productId,
            'quantity'   => 0,
            'unit'       => 'pcs',
            'status'     => 'Out of Stock',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('baker.products.index')
                         ->with('success', 'Product added successfully!');
    }

    public function destroy($id)
    {
        DB::table('products')->where('id', $id)->delete();
        return response()->json(['success' => true]);
    }
}