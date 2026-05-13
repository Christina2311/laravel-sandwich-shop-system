<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Add subtotal column to order_items ──────────────────────────
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->default(0)->after('unit_price');
        });

        // ── 2. Backfill unit_price and subtotal ────────────────────────────
        // Fix items saved with unit_price = 0 before prices were set.
        DB::statement("
            UPDATE order_items oi
            JOIN   products p ON oi.product_id = p.id
            SET
                oi.unit_price = p.price,
                oi.subtotal   = p.price * oi.quantity
            WHERE  oi.unit_price = 0
              AND  p.price > 0
        ");

        // ── 3. Recalculate order totals ────────────────────────────────────
        // Recompute subtotal, tax (12%), and total_amount for all orders.
        DB::statement("
            UPDATE orders o
            JOIN (
                SELECT
                    order_id,
                    SUM(unit_price * quantity)                   AS new_subtotal,
                    ROUND(SUM(unit_price * quantity) * 0.12, 2)  AS new_tax,
                    ROUND(SUM(unit_price * quantity) * 1.12, 2)  AS new_total
                FROM order_items
                WHERE unit_price > 0
                GROUP BY order_id
            ) AS calc ON calc.order_id = o.id
            SET
                o.subtotal     = calc.new_subtotal,
                o.tax          = calc.new_tax,
                o.total_amount = calc.new_total
        ");
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('subtotal');
        });
    }
};