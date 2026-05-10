<?php

namespace App\Http\Controllers\Manager;          // ← changed from Baker

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
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
                DB::raw('products.updated_at as product_updated_at'),
                'inventory.quantity as inventory_qty',
                'inventory.unit as inventory_unit',
                DB::raw("CONCAT(COALESCE(employees.employee_fn, 'N/A'), ' ', COALESCE(employees.employee_ln, '')) as managed_by")
            )
            ->where('products.category', 'Sandwich')
            ->where('products.is_active', 1)
            ->orderBy('products.name')
            ->get();

        $activeCount = $products->count();
        $categories  = ['Sandwich'];

        return view('manager.products.index', compact('products', 'activeCount', 'categories'));  // ← changed from baker.products.index
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
        ]);

        DB::table('products')->insertGetId([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'category'    => $request->category,
            'is_active'   => $request->is_active ?? 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // No inventory record created here.
        // Stock will be added through the Inventory → Stock In flow.

        return redirect()->route('manager.products')
                         ->with('success', 'Product added successfully! Use Stock In to add inventory.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
        ]);

        DB::table('products')->where('id', $id)->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'category'    => $request->category,
            'updated_at'  => now(),
        ]);

        return redirect()->route('manager.products')
                         ->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('products')->where('id', $id)->delete();
        DB::table('inventory')->where('product_id', $id)->delete();

        return redirect()->route('manager.products')
                         ->with('success', 'Product deleted successfully!');
    }
}