<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\StockInRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $inventories = Inventory::with('product')->orderByDesc('updated_at')->get();
        $stockIns    = StockIn::with('product', 'employee')->orderByDesc('created_at')->get();
        $stockOuts   = StockOut::with('product', 'employee')->orderByDesc('created_at')->get();
        $products    = Product::orderBy('name')->get();
        $categories  = Product::select('category')->distinct()->whereNotNull('category')->pluck('category');

        return view('manager.inventorymanagement.index', compact(
            'inventories',
            'stockIns',
            'stockOuts',
            'products',
            'categories'
        ));
    }

    /**
     * Resolve a product by name, creating it if it doesn't exist yet.
     */
    private function resolveProductId(string $name): int
    {
        $product = Product::firstOrCreate(
            ['name' => trim($name)],
            ['name' => trim($name), 'category' => 'Uncategorized']
        );
        return $product->id;
    }

    /**
     * Resolve the logged-in user's employee record ID.
     */
    private function resolveEmployeeId(): int
    {
        $employee = auth()->user()->employee;

        if (!$employee) {
            abort(403, 'No employee record linked to this account.');
        }

        return $employee->id;
    }

    /**
     * Manager records Stock In directly — no request/approval needed.
     */
    public function storeStockIn(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity'     => 'required|integer|min:1',
            'date'         => 'required|date',
            'supplier'     => 'nullable|string|max:255',
            'note'         => 'nullable|string',
        ]);

        $employeeId = $this->resolveEmployeeId();
        $productId  = $this->resolveProductId($request->product_name);

        DB::transaction(function () use ($request, $employeeId, $productId) {
            StockIn::create([
                'employee_id' => $employeeId,
                'product_id'  => $productId,
                'quantity'    => $request->quantity,
                'supplier'    => $request->supplier,
                'date'        => $request->date,
                'note'        => $request->note,
            ]);

            $inventory = Inventory::where('product_id', $productId)->first();

            if ($inventory) {
                $newQty = $inventory->quantity + $request->quantity;
                $inventory->update([
                    'quantity' => $newQty,
                    'status'   => $this->resolveStatus($newQty),
                ]);
            } else {
                Inventory::create([
                    'product_id' => $productId,
                    'quantity'   => $request->quantity,
                    'unit'       => 'pcs',
                    'status'     => $this->resolveStatus($request->quantity),
                ]);
            }
        });

        return redirect()->route('manager.inventory')
            ->with('success', 'Stock In recorded successfully.');
    }

    /**
     * Manager records Stock Out and deducts from inventory.
     */
    public function storeStockOut(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity'     => 'required|integer|min:1',
            'date'         => 'required|date',
            'reason'       => 'required|in:sold,expired,damaged,other',
            'note'         => 'nullable|string',
        ]);

        $employeeId = $this->resolveEmployeeId();
        $productId  = $this->resolveProductId($request->product_name);
        $inventory  = Inventory::where('product_id', $productId)->first();

        if (!$inventory || $inventory->quantity < $request->quantity) {
            return redirect()->back()
                ->with('error', 'Insufficient stock for this product.');
        }

        DB::transaction(function () use ($request, $employeeId, $productId, $inventory) {
            StockOut::create([
                'employee_id' => $employeeId,
                'product_id'  => $productId,
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

        return redirect()->route('manager.inventory')
            ->with('success', 'Stock Out recorded successfully.');
    }

    private function resolveStatus(int $qty): string
    {
        if ($qty <= 0)  return 'Out of Stock';
        if ($qty <= 10) return 'Low Stock';
        return 'In Stock';
    }
}