<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Baker\InventoryController;
use App\Http\Controllers\Manager\EmployeeController;
use App\Http\Controllers\Manager\StockRequestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->hasRole('seller')) {
        return redirect()->route('seller.dashboard');
    }

    if ($user->hasRole('baker')) {
        return redirect()->route('baker.queue');
    }

    if ($user->hasRole('manager')) {
        return redirect()->route('manager.dashboard');
    }

    abort(403, 'Unauthorized');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/select-role', function () {
        $roles = Auth::user()->roles()->pluck('role_name')->toArray();
        return view('auth.select-role', compact('roles'));
    })->name('role.select');
});

// ── Manager ──────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {

        // Dashboard
        Route::get('dashboard', [\App\Http\Controllers\Manager\DashboardController::class, 'index'])
            ->name('dashboard');

        // Employee Resource
        Route::resource('employees', \App\Http\Controllers\Manager\EmployeeController::class)
            ->except(['destroy']);
        Route::patch('employees/{id}/archive', [\App\Http\Controllers\Manager\EmployeeController::class, 'archive'])
            ->name('employees.archive');

        // Stock Requests (Baker → Manager approval)
        Route::get('stock-requests', [StockRequestController::class, 'index'])
            ->name('stockrequests.index');
        Route::patch('stock-requests/{stockRequest}/approve', [StockRequestController::class, 'approve'])
            ->name('stockrequests.approve');
        Route::patch('stock-requests/{stockRequest}/reject', [StockRequestController::class, 'reject'])
            ->name('stockrequests.reject');

        Route::get('inventory', [\App\Http\Controllers\Baker\InventoryController::class, 'index'])
            ->name('inventory');
        Route::get('products', [\App\Http\Controllers\Manager\ProductController::class, 'index'])
            ->name('products');
        Route::get('/reports', [\App\Http\Controllers\Manager\ReportController::class, 'index'])
            ->name('reports');
    });

// ── Seller ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Seller\DashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('neworder', [\App\Http\Controllers\Seller\NewOrderController::class, 'index'])
            ->name('neworder.index');
        Route::post('neworder', [\App\Http\Controllers\Seller\NewOrderController::class, 'store'])
            ->name('neworder.store');
    });

// ── Baker ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:baker'])
    ->prefix('baker')
    ->name('baker.')
    ->group(function () {
        Route::get('queue', [\App\Http\Controllers\Baker\QueueController::class, 'index'])->name('queue');
        Route::patch('queue/{order}', [\App\Http\Controllers\Baker\QueueController::class, 'update'])->name('queue.update');

        Route::get('inventory', [InventoryController::class, 'index'])->name('inventorymanagement.index');
        Route::post('/inventory/stock-in', [InventoryController::class, 'storeStockIn'])->name('inventory.storeStockIn');
        Route::post('/inventory/stock-out', [InventoryController::class, 'storeStockOut'])->name('inventory.storeStockOut');

        Route::get('products', [\App\Http\Controllers\Baker\ProductController::class, 'index'])->name('products');
        Route::get('orders/report', [\App\Http\Controllers\Baker\OrderReportController::class, 'index'])->name('orders.report');
        Route::get('orders/report/{order}', [\App\Http\Controllers\Baker\OrderReportController::class, 'show'])->name('orders.report.show');
    });

require __DIR__.'/auth.php';