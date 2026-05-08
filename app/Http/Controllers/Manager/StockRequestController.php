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
     * Show all pending stock requests to the manager.
     */
    public function index()
    {
        $pendingRequests = StockInRequest::with(['product', 'employee'])
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        $historyRequests = StockInRequest::with(['product', 'employee'])
            ->whereIn('status', ['approved', 'rejected'])
            ->orderByDesc('updated_at')
            ->take(50)
            ->get();

        return view('manager.stockrequests.index', compact('pendingRequests', 'historyRequests'));
    }

    /**
     * Approve a stock request — updates inventory and creates StockIn record.
     */
    public function approve(Request $request, StockInRequest $stockRequest)
    {
        if ($stockRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        DB::transaction(function () use ($request, $stockRequest) {
            // Create actual StockIn record
            StockIn::create([
                'employee_id' => $stockRequest->employee_id,
                'product_id'  => $stockRequest->product_id,
                'quantity'    => $stockRequest->quantity,
                'supplier'    => $stockRequest->supplier,
                'date'        => $stockRequest->date,
                'note'        => $stockRequest->note,
            ]);

            // Update or create inventory
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

            // Mark request as approved
            $stockRequest->update([
                'status'       => 'approved',
                'manager_note' => $request->manager_note,
            ]);
        });

        return redirect()->route('manager.stock-requests.index')
            ->with('success', 'Stock request approved and inventory updated.');
    }

    /**
     * Reject a stock request.
     */
    public function reject(Request $request, StockInRequest $stockRequest)
    {
        $request->validate([
            'manager_note' => 'nullable|string|max:500',
        ]);

        if ($stockRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        $stockRequest->update([
            'status'       => 'rejected',
            'manager_note' => $request->manager_note,
        ]);

        return redirect()->route('manager.stock-requests.index')
            ->with('success', 'Stock request rejected.');
    }

    private function resolveStatus(int $qty): string
    {
        if ($qty <= 0)  return 'Out of Stock';
        if ($qty <= 10) return 'Low Stock';
        return 'In Stock';
    }
}