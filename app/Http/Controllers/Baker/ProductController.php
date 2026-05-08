<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        // ✅ SHOW ONLY SANDWICHES (Final Products), hide raw ingredients
        $products = DB::table('products')
            ->leftJoin('inventory', 'products.id', '=', 'inventory.product_id')
            ->leftJoin('employees', function($join) {
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
                DB::raw("CONCAT(COALESCE(employees.employee_fn, 'Tom'), ' ', COALESCE(employees.employee_ln, 'Baker')) as managed_by")
            )
            ->where('products.category', 'Sandwich')           // ← Only Sandwiches
            ->where('products.is_active', 1)
            ->orderBy('products.name')
            ->get();

        $activeCount = $products->count();
        $categories  = ['Sandwich'];

        return view('baker.products.index', compact('products', 'activeCount', 'categories'));
    }

    // Keep your existing store and destroy methods
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

        DB::table('inventory')->insert([
            'product_id' => $productId,
            'quantity'   => 100,
            'unit'       => 'pack',
            'status'     => 'In Stock',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('baker.products.index')
                         ->with('success', 'Product added successfully!');
    }

    public function destroy($id)
    {
        DB::table('products')->where('id', $id)->delete();
        DB::table('inventory')->where('product_id', $id)->delete();
        return response()->json(['success' => true]);
    }
}