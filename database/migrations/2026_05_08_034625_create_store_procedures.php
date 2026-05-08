<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetPendingOrders');
        DB::unprepared('
            CREATE PROCEDURE GetPendingOrders()
            BEGIN
                SELECT orders.*, customers.customer_fn, customers.customer_ln
                FROM orders
                LEFT JOIN customers ON orders.customer_id = customers.id
                WHERE orders.status = "Pending"
                ORDER BY orders.created_at ASC;
            END
        ');

        DB::unprepared('DROP PROCEDURE IF EXISTS GetPreparingOrders');
        DB::unprepared('
            CREATE PROCEDURE GetPreparingOrders()
            BEGIN
                SELECT orders.*, customers.customer_fn, customers.customer_ln
                FROM orders
                LEFT JOIN customers ON orders.customer_id = customers.id
                WHERE orders.status = "Preparing"
                ORDER BY orders.created_at ASC;
            END
        ');

        DB::unprepared('DROP PROCEDURE IF EXISTS GetCompletedOrders');
        DB::unprepared('
            CREATE PROCEDURE GetCompletedOrders()
            BEGIN
                SELECT orders.*, customers.customer_fn, customers.customer_ln
                FROM orders
                LEFT JOIN customers ON orders.customer_id = customers.id
                WHERE orders.status = "Completed"
                ORDER BY orders.updated_at DESC;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetPendingOrders');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetPreparingOrders');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCompletedOrders');
    }
};