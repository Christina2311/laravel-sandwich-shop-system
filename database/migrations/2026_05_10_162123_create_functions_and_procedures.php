<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ══════════════════════════════════════════════════════════════════
        // STORED FUNCTIONS
        // ══════════════════════════════════════════════════════════════════

        // ── 1. GetTotalRevenueToday ────────────────────────────────────────
        // Returns the sum of total_amount for all Ready + Completed orders
        // placed today. Used on the seller dashboard revenue card.
        DB::unprepared('DROP FUNCTION IF EXISTS GetTotalRevenueToday');
        DB::unprepared('
            CREATE FUNCTION GetTotalRevenueToday()
            RETURNS DECIMAL(10,2)
            READS SQL DATA
            BEGIN
                DECLARE revenue DECIMAL(10,2);
                SELECT COALESCE(SUM(total_amount), 0.00)
                INTO   revenue
                FROM   orders
                WHERE  DATE(created_at) = CURDATE()
                  AND  status IN ("Ready", "Completed");
                RETURN revenue;
            END
        ');

        // ── 2. GetTodayOrderCount ──────────────────────────────────────────
        // Returns the total number of orders placed today (all statuses).
        DB::unprepared('DROP FUNCTION IF EXISTS GetTodayOrderCount');
        DB::unprepared('
            CREATE FUNCTION GetTodayOrderCount()
            RETURNS INT
            READS SQL DATA
            BEGIN
                DECLARE total INT;
                SELECT COUNT(*)
                INTO   total
                FROM   orders
                WHERE  DATE(created_at) = CURDATE();
                RETURN total;
            END
        ');

        // ── 3. GetTotalCustomers ───────────────────────────────────────────
        // Returns the total number of registered customers.
        DB::unprepared('DROP FUNCTION IF EXISTS GetTotalCustomers');
        DB::unprepared('
            CREATE FUNCTION GetTotalCustomers()
            RETURNS INT
            READS SQL DATA
            BEGIN
                DECLARE total INT;
                SELECT COUNT(*) INTO total FROM customers;
                RETURN total;
            END
        ');

        // ── 4. GetLowStockCount ────────────────────────────────────────────
        // Returns the number of inventory items with quantity <= 20.
        DB::unprepared('DROP FUNCTION IF EXISTS GetLowStockCount');
        DB::unprepared('
            CREATE FUNCTION GetLowStockCount()
            RETURNS INT
            READS SQL DATA
            BEGIN
                DECLARE total INT;
                SELECT COUNT(*)
                INTO   total
                FROM   inventory
                WHERE  quantity <= 20;
                RETURN total;
            END
        ');

        // ── 5. GetOrderTotal ───────────────────────────────────────────────
        // Returns the total_amount for a given order ID.
        // Usage: SELECT GetOrderTotal(5);
        DB::unprepared('DROP FUNCTION IF EXISTS GetOrderTotal');
        DB::unprepared('
            CREATE FUNCTION GetOrderTotal(p_order_id BIGINT)
            RETURNS DECIMAL(10,2)
            READS SQL DATA
            BEGIN
                DECLARE total DECIMAL(10,2);
                SELECT COALESCE(total_amount, 0.00)
                INTO   total
                FROM   orders
                WHERE  id = p_order_id;
                RETURN total;
            END
        ');

        // ── 6. GetEmployeeOrderCount ───────────────────────────────────────
        // Returns how many orders a seller has processed (by seller_id).
        // Usage: SELECT GetEmployeeOrderCount(5);
        DB::unprepared('DROP FUNCTION IF EXISTS GetEmployeeOrderCount');
        DB::unprepared('
            CREATE FUNCTION GetEmployeeOrderCount(p_employee_id BIGINT)
            RETURNS INT
            READS SQL DATA
            BEGIN
                DECLARE total INT;
                SELECT COUNT(*)
                INTO   total
                FROM   orders
                WHERE  seller_id = p_employee_id;
                RETURN total;
            END
        ');

        // ── 7. GetRevenueByDate ────────────────────────────────────────────
        // Returns total revenue (Ready + Completed) for a specific date.
        // Usage: SELECT GetRevenueByDate("2026-05-10");
        DB::unprepared('DROP FUNCTION IF EXISTS GetRevenueByDate');
        DB::unprepared('
            CREATE FUNCTION GetRevenueByDate(p_date DATE)
            RETURNS DECIMAL(10,2)
            READS SQL DATA
            BEGIN
                DECLARE revenue DECIMAL(10,2);
                SELECT COALESCE(SUM(total_amount), 0.00)
                INTO   revenue
                FROM   orders
                WHERE  DATE(created_at) = p_date
                  AND  status IN ("Ready", "Completed");
                RETURN revenue;
            END
        ');


        // ══════════════════════════════════════════════════════════════════
        // STORED PROCEDURES
        // ══════════════════════════════════════════════════════════════════

        // ── 1. GetPendingOrders (replace existing) ─────────────────────────
        DB::unprepared('DROP PROCEDURE IF EXISTS GetPendingOrders');
        DB::unprepared('
            CREATE PROCEDURE GetPendingOrders()
            BEGIN
                SELECT orders.*,
                       COALESCE(CONCAT(customers.customer_fn, " ", customers.customer_ln), "Walk-in Customer") AS customer_name
                FROM   orders
                LEFT JOIN customers ON orders.customer_id = customers.id
                WHERE  orders.status = "Pending"
                ORDER BY orders.created_at ASC;
            END
        ');

        // ── 2. GetPreparingOrders (replace existing) ───────────────────────
        DB::unprepared('DROP PROCEDURE IF EXISTS GetPreparingOrders');
        DB::unprepared('
            CREATE PROCEDURE GetPreparingOrders()
            BEGIN
                SELECT orders.*,
                       COALESCE(CONCAT(customers.customer_fn, " ", customers.customer_ln), "Walk-in Customer") AS customer_name
                FROM   orders
                LEFT JOIN customers ON orders.customer_id = customers.id
                WHERE  orders.status = "Preparing"
                ORDER BY orders.created_at ASC;
            END
        ');

        // ── 3. GetCompletedOrders (replace existing) ───────────────────────
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCompletedOrders');
        DB::unprepared('
            CREATE PROCEDURE GetCompletedOrders()
            BEGIN
                SELECT orders.*,
                       COALESCE(CONCAT(customers.customer_fn, " ", customers.customer_ln), "Walk-in Customer") AS customer_name
                FROM   orders
                LEFT JOIN customers ON orders.customer_id = customers.id
                WHERE  orders.status IN ("Ready", "Completed")
                ORDER BY orders.updated_at DESC;
            END
        ');

        // ── 4. GetDashboardStats ───────────────────────────────────────────
        // Returns all 4 dashboard stat card values in a single call.
        // Uses the stored functions defined above.
        DB::unprepared('DROP PROCEDURE IF EXISTS GetDashboardStats');
        DB::unprepared('
            CREATE PROCEDURE GetDashboardStats()
            BEGIN
                SELECT
                    GetTodayOrderCount()    AS today_order_count,
                    GetTotalCustomers()     AS total_customers,
                    GetLowStockCount()      AS low_stock_count,
                    GetTotalRevenueToday()  AS total_revenue_today;
            END
        ');

        // ── 5. GetRecentOrders ─────────────────────────────────────────────
        // Returns the most recent 50 orders with customer name.
        // Walk-in orders (no customer) are included as "Walk-in Customer".
        DB::unprepared('DROP PROCEDURE IF EXISTS GetRecentOrders');
        DB::unprepared('
            CREATE PROCEDURE GetRecentOrders()
            BEGIN
                SELECT
                    orders.id,
                    orders.status,
                    orders.total_amount,
                    COALESCE(
                        CONCAT(customers.customer_fn, " ", customers.customer_ln),
                        "Walk-in Customer"
                    ) AS customer_name
                FROM   orders
                LEFT JOIN customers ON orders.customer_id = customers.id
                ORDER BY orders.created_at DESC
                LIMIT 50;
            END
        ');

        // ── 6. GetTopProductsToday ─────────────────────────────────────────
        // Returns the top-selling products for today, ranked by qty sold.
        DB::unprepared('DROP PROCEDURE IF EXISTS GetTopProductsToday');
        DB::unprepared('
            CREATE PROCEDURE GetTopProductsToday()
            BEGIN
                SELECT
                    products.name,
                    SUM(order_items.quantity) AS total_sold
                FROM   order_items
                JOIN   orders   ON order_items.order_id  = orders.id
                JOIN   products ON order_items.product_id = products.id
                WHERE  DATE(orders.created_at) = CURDATE()
                GROUP BY products.id, products.name
                ORDER BY total_sold DESC;
            END
        ');

        // ── 7. GetOrdersByStatus ───────────────────────────────────────────
        // Returns all orders filtered by a given status.
        // Usage: CALL GetOrdersByStatus("Completed");
        DB::unprepared('DROP PROCEDURE IF EXISTS GetOrdersByStatus');
        DB::unprepared('
            CREATE PROCEDURE GetOrdersByStatus(IN p_status VARCHAR(20))
            BEGIN
                SELECT
                    orders.id,
                    orders.status,
                    orders.total_amount,
                    orders.created_at,
                    COALESCE(
                        CONCAT(customers.customer_fn, " ", customers.customer_ln),
                        "Walk-in Customer"
                    ) AS customer_name
                FROM   orders
                LEFT JOIN customers ON orders.customer_id = customers.id
                WHERE  orders.status = p_status
                ORDER BY orders.created_at DESC;
            END
        ');

        // ── 8. GetOrdersByDateRange ────────────────────────────────────────
        // Returns orders placed between two dates (inclusive).
        // Usage: CALL GetOrdersByDateRange("2026-05-01", "2026-05-10");
        DB::unprepared('DROP PROCEDURE IF EXISTS GetOrdersByDateRange');
        DB::unprepared('
            CREATE PROCEDURE GetOrdersByDateRange(IN p_from DATE, IN p_to DATE)
            BEGIN
                SELECT
                    orders.id,
                    orders.status,
                    orders.total_amount,
                    orders.created_at,
                    COALESCE(
                        CONCAT(customers.customer_fn, " ", customers.customer_ln),
                        "Walk-in Customer"
                    ) AS customer_name
                FROM   orders
                LEFT JOIN customers ON orders.customer_id = customers.id
                WHERE  DATE(orders.created_at) BETWEEN p_from AND p_to
                ORDER BY orders.created_at DESC;
            END
        ');

        // ── 9. GetSellerPerformance ────────────────────────────────────────
        // Returns each seller's order count and total revenue processed.
        DB::unprepared('DROP PROCEDURE IF EXISTS GetSellerPerformance');
        DB::unprepared('
            CREATE PROCEDURE GetSellerPerformance()
            BEGIN
                SELECT
                    CONCAT(e.employee_fn, " ", e.employee_ln) AS seller_name,
                    COUNT(o.id)                                AS total_orders,
                    COALESCE(SUM(o.total_amount), 0.00)        AS total_revenue
                FROM   employees e
                LEFT JOIN orders o ON o.seller_id = e.id
                GROUP BY e.id, e.employee_fn, e.employee_ln
                ORDER BY total_revenue DESC;
            END
        ');

        // ── 10. GetBakerPerformance ────────────────────────────────────────
        // Returns each baker's order count (how many orders they prepared).
        DB::unprepared('DROP PROCEDURE IF EXISTS GetBakerPerformance');
        DB::unprepared('
            CREATE PROCEDURE GetBakerPerformance()
            BEGIN
                SELECT
                    CONCAT(e.employee_fn, " ", e.employee_ln) AS baker_name,
                    COUNT(o.id)                                AS total_orders_prepared
                FROM   employees e
                LEFT JOIN orders o ON o.baker_id = e.id
                GROUP BY e.id, e.employee_fn, e.employee_ln
                ORDER BY total_orders_prepared DESC;
            END
        ');
    }

    public function down(): void
    {
        // Drop functions
        DB::unprepared('DROP FUNCTION IF EXISTS GetTotalRevenueToday');
        DB::unprepared('DROP FUNCTION IF EXISTS GetTodayOrderCount');
        DB::unprepared('DROP FUNCTION IF EXISTS GetTotalCustomers');
        DB::unprepared('DROP FUNCTION IF EXISTS GetLowStockCount');
        DB::unprepared('DROP FUNCTION IF EXISTS GetOrderTotal');
        DB::unprepared('DROP FUNCTION IF EXISTS GetEmployeeOrderCount');
        DB::unprepared('DROP FUNCTION IF EXISTS GetRevenueByDate');

        // Drop procedures
        DB::unprepared('DROP PROCEDURE IF EXISTS GetPendingOrders');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetPreparingOrders');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCompletedOrders');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetDashboardStats');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetRecentOrders');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetTopProductsToday');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetOrdersByStatus');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetOrdersByDateRange');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetSellerPerformance');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetBakerPerformance');
    }
};