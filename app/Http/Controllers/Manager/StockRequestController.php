<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\StockInRequest;
use App\Models\StockIn;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockRequestController extends Controller
{
    /**
     * List all pending (and recent) baker stock-in requests.
     */
   public function index()
    {
        $pendingRequests = StockInRequest::with('product', 'employee')
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        $historyRequests = StockInRequest::with('product', 'employee')
            ->whereIn('status', ['approved', 'rejected'])
            ->orderByDesc('updated_at')
            ->limit(50)
            ->get();

        return view('manager.stockrequests.index', compact('pendingRequests', 'historyRequests'));
    }

    /**
     * Approve a baker's stock-in request.
     * This creates the actual StockIn record and updates inventory.
     */
    public function approve(Request $request, StockInRequest $stockRequest)
    {
        if ($stockRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        $request->validate([
            'manager_note' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($stockRequest, $request) {
            // 1. Create the official StockIn record
            StockIn::create([
                'employee_id' => $stockRequest->employee_id,
                'product_id'  => $stockRequest->product_id,
                'quantity'    => $stockRequest->quantity,
                'supplier'    => $stockRequest->supplier,
                'date'        => $stockRequest->date,
                'note'        => $stockRequest->note,
            ]);

            // 2. Update or create inventory record
            $inventory = Inventory::where('product_id', $stockRequest->product_id)->first();

            if ($inventory) {
                $newQty = $inventory->quantity + $stockRequest->quantity;
                $inventory->update([
                    'quantity' => $newQty,
                    'status'   => $this->resolveStatus($newQty),
                ]);
            } else {
                Inventory::create([
                    'product_id' => $stockRequest->product_id,
                    'quantity'   => $stockRequest->quantity,
                    'unit'       => 'pcs',
                    'status'     => $this->resolveStatus($stockRequest->quantity),
                ]);
            }

            // 3. Mark request as approved and save manager_note
            $stockRequest->update([
                'status'       => 'approved',
                'manager_note' => $request->manager_note, // ← fixed: was never saved
            ]);
        });

        return redirect()->back()->with('success', 'Stock-in request approved and inventory updated.');
    }

    /**
     * Reject a baker's stock-in request, with an optional manager note.
     */
    public function reject(Request $request, StockInRequest $stockRequest)
    {
        if ($stockRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        $request->validate([
            'manager_note' => 'nullable|string|max:500',
        ]);

        $stockRequest->update([
            'status'       => 'rejected',
            'manager_note' => $request->manager_note,
        ]);

        return redirect()->back()->with('success', 'Stock-in request rejected.');
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