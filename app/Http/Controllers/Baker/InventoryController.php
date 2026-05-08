<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\StockInRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        // Baker's own pending requests
        $employee    = Auth::user()->employee;
        $myRequests  = StockInRequest::with('product')
            ->where('employee_id', $employee?->id)
            ->orderByDesc('created_at')
            ->get();

        return view('baker.inventorymanagement.index', compact(
            'inventories',
            'stockIns',
            'stockOuts',
            'products',
            'categories',
            'myRequests'
        ));
    }

    /**
     * Baker submits a Stock In REQUEST (does NOT update inventory directly).
     * Manager must approve before inventory is updated.
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

        StockInRequest::create([
            'employee_id' => $request->employee_id,
            'product_id'  => $request->product_id,
            'quantity'    => $request->quantity,
            'supplier'    => $request->supplier,
            'date'        => $request->date,
            'note'        => $request->note,
            'status'      => 'pending',
        ]);

        return redirect()->route('baker.inventorymanagement.index')
            ->with('success', 'Stock request submitted! Awaiting manager approval.');
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
            StockOut::create([
                'employee_id' => $request->employee_id,
                'product_id'  => $request->product_id,
                'quantity'    => $request->quantity,
                'date'        => $request->date,
                'reason'      => $request->reason,
                'note'        => $request->note,
            ]);

            $newQty = $inventory->quantity - $request->quantity;
            $inventory->update([
                'quantity' => $newQty,
                'status'   => $this->resolveStatus($newQty),
            ]);
        });

        return redirect()->route('baker.inventorymanagement.index')
            ->with('success', 'Stock Out recorded successfully.');
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