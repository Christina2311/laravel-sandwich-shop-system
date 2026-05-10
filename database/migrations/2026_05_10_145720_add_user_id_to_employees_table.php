<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('users')
                  ->nullOnDelete();
        });

        // Auto-link existing employees to users by matching email.
        // Employees don't have an email column, so we match on name:
        // users.name  ↔  CONCAT(employee_fn, ' ', employee_ln)
        // Adjust this query if your naming convention differs.
        DB::statement("
            UPDATE employees e
            INNER JOIN users u
                ON u.name = CONCAT(e.employee_fn, ' ', e.employee_ln)
            SET e.user_id = u.id
            WHERE e.user_id IS NULL
        ");
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};