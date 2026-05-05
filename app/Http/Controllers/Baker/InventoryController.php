<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display the Inventory Management page.
     */
    public function index(Request $request)
    {
        $inventories = Inventory::with('product')->orderByDesc('updated_at')->get();
        $stockIns    = StockIn::with('product')->orderByDesc('date')->get();
        $stockOuts   = StockOut::with('product')->orderByDesc('date')->get();
        $products    = Product::orderBy('name')->get();

        // Unique categories for the filter dropdown (from products)
        $categories  = Product::select('category')->distinct()->whereNotNull('category')->pluck('category');

        return view('baker.inventorymanagement.index', compact(
            'inventories',
            'stockIns',
            'stockOuts',
            'products',
            'categories'
        ));
    }

    /**
     * Store a new Stock In record and update inventory.
     */
    public function storeStockIn(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|integer|min:1',
            'date'        => 'required|date',
            'supplier'    => 'nullable|string|max:255',
            'note'        => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // Create stock in record
            StockIn::create([
                'employee_id' => $request->employee_id,
                'product_id'  => $request->product_id,
                'quantity'    => $request->quantity,
                'supplier'    => $request->supplier,
                'date'        => $request->date,
                'note'        => $request->note,
            ]);

            // Update or create inventory
            $inventory = Inventory::where('product_id', $request->product_id)->first();

            if ($inventory) {
                $newQty = $inventory->quantity + $request->quantity;
                $inventory->update([
                    'quantity' => $newQty,
                    'status'   => $this->resolveStatus($newQty),
                ]);
            } else {
                Inventory::create([
                    'product_id' => $request->product_id,
                    'quantity'   => $request->quantity,
                    'unit'       => 'pcs',
                    'status'     => $this->resolveStatus($request->quantity),
                ]);
            }
        });

        return redirect()->route('baker.inventory.index')->with('success', 'Stock In recorded successfully.');
    }

    /**
     * Store a new Stock Out record and update inventory.
     */
    public function storeStockOut(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|integer|min:1',
            'date'        => 'required|date',
            'reason'      => 'required|in:sold,expired,damaged,other',
            'note'        => 'nullable|string',
        ]);

        $inventory = Inventory::where('product_id', $request->product_id)->first();

        if (!$inventory || $inventory->quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock for this product.');
        }

        DB::transaction(function () use ($request, $inventory) {
            // Create stock out record
            StockOut::create([
                'employee_id' => $request->employee_id,
                'product_id'  => $request->product_id,
                'quantity'    => $request->quantity,
                'date'        => $request->date,
                'reason'      => $request->reason,
                'note'        => $request->note,
            ]);

            // Deduct from inventory
            $newQty = $inventory->quantity - $request->quantity;
            $inventory->update([
                'quantity' => $newQty,
                'status'   => $this->resolveStatus($newQty),
            ]);
        });

        return redirect()->route('baker.inventory.index')->with('success', 'Stock Out recorded successfully.');
    }

    /**
     * Determine inventory status based on quantity.
     */
    private function resolveStatus(int $qty): string
    {
        if ($qty <= 0)  return 'Out of Stock';
        if ($qty <= 10) return 'Low Stock';
        return 'In Stock';
    }
}