<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ══════════════════════════════════════════════════
        // 1. ROLES
        // ══════════════════════════════════════════════════
        $roles = ['Manager', 'Seller', 'Baker'];

        foreach ($roles as $roleName) {
            DB::table('roles')->insertOrIgnore([
                'role_name'  => $roleName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $managerId = DB::table('roles')->where('role_name', 'Manager')->value('id');
        $sellerId  = DB::table('roles')->where('role_name', 'Seller')->value('id');
        $bakerId   = DB::table('roles')->where('role_name', 'Baker')->value('id');


        // ══════════════════════════════════════════════════
        // 2. USERS
        //    user_id 1 → Chrisha Velasquez  → Manager (no employee record)
        //    user_id 2 → Christina Yute     → Seller (employee #5)
        //    user_id 3 → Tom Baker          → Baker  (employee #7)
        //    user_id 4 → Alex Both          → Seller + Baker (employee #6)
        // ══════════════════════════════════════════════════
        $users = [
            [
                'id'       => 1,
                'name'     => 'Chrisha Velasquez',
                'email'    => 'manager@sandwichshop.com',
                'password' => Hash::make('password'),
            ],
            [
                'id'       => 2,
                'name'     => 'Christina Yute',
                'email'    => 'seller@sandwichshop.com',
                'password' => Hash::make('password'),
            ],
            [
                'id'       => 3,
                'name'     => 'Tom Baker',
                'email'    => 'baker@sandwichshop.com',
                'password' => Hash::make('password'),
            ],
            [
                'id'       => 4,
                'name'     => 'Alex Both',
                'email'    => 'both@sandwichshop.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insertOrIgnore(array_merge($user, [
                'email_verified_at' => null,
                'remember_token'    => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]));
        }

        // Link users → roles (role_user pivot)
        DB::table('role_user')->insertOrIgnore([
            // Manager
            ['user_id' => 1, 'role_id' => $managerId],
            // Seller only (Christina)
            ['user_id' => 2, 'role_id' => $sellerId],
            // Baker only (Tom)
            ['user_id' => 3, 'role_id' => $bakerId],
            // Seller + Baker (Alex)
            ['user_id' => 4, 'role_id' => $sellerId],
            ['user_id' => 4, 'role_id' => $bakerId],
        ]);


        // ══════════════════════════════════════════════════
        // 3. EMPLOYEES
        //
        //  #1  Maria Reyes       → Seller         (no login account)
        //  #2  Juan dela Cruz    → Baker           (no login account)
        //  #3  Pedro Santos      → Seller          (no login account)
        //  #4  Rosa Bautista     → Baker           (no login account)
        //  #5  Christina Yute    → Seller + Baker  → user_id = 2
        //  #6  Alex Both         → Seller + Baker  → user_id = 4
        //  #7  Tom Baker         → Baker           → user_id = 3  ← ADDED
        // ══════════════════════════════════════════════════
        $employees = [
            [
                'id'             => 1,
                'user_id'        => null,          // no login account
                'employee_fn'    => 'Maria',
                'employee_ln'    => 'Reyes',
                'e_barangay'     => 'Barangay 1',
                'e_city'         => 'Quezon City',
                'e_contact_info' => '09171234567',
                'is_active'      => 1,
                'roles'          => [$sellerId],
            ],
            [
                'id'             => 2,
                'user_id'        => null,
                'employee_fn'    => 'Juan',
                'employee_ln'    => 'dela Cruz',
                'e_barangay'     => 'Barangay 2',
                'e_city'         => 'Quezon City',
                'e_contact_info' => '09182345678',
                'is_active'      => 1,
                'roles'          => [$bakerId],
            ],
            [
                'id'             => 3,
                'user_id'        => null,
                'employee_fn'    => 'Pedro',
                'employee_ln'    => 'Santos',
                'e_barangay'     => 'Barangay 3',
                'e_city'         => 'Quezon City',
                'e_contact_info' => '09193456789',
                'is_active'      => 1,
                'roles'          => [$sellerId],
            ],
            [
                'id'             => 4,
                'user_id'        => null,
                'employee_fn'    => 'Rosa',
                'employee_ln'    => 'Bautista',
                'e_barangay'     => 'Barangay 4',
                'e_city'         => 'Quezon City',
                'e_contact_info' => '09204567890',
                'is_active'      => 1,
                'roles'          => [$bakerId],
            ],
            [
                'id'             => 5,
                'user_id'        => 2,             // seller@sandwichshop.com
                'employee_fn'    => 'Christina',
                'employee_ln'    => 'Yute',
                'e_barangay'     => 'Barangay 5',
                'e_city'         => 'Quezon City',
                'e_contact_info' => '09215678901',
                'is_active'      => 1,
                'roles'          => [$sellerId, $bakerId],
            ],
            [
                'id'             => 6,
                'user_id'        => 4,             // both@sandwichshop.com
                'employee_fn'    => 'Alex',
                'employee_ln'    => 'Both',
                'e_barangay'     => 'Barangay 6',
                'e_city'         => 'Quezon City',
                'e_contact_info' => '09226789012',
                'is_active'      => 1,
                'roles'          => [$sellerId, $bakerId],
            ],
            [
                'id'             => 7,
                'user_id'        => 3,             // baker@sandwichshop.com ← NEW
                'employee_fn'    => 'Tom',
                'employee_ln'    => 'Baker',
                'e_barangay'     => 'Barangay 7',
                'e_city'         => 'Quezon City',
                'e_contact_info' => '09237890123',
                'is_active'      => 1,
                'roles'          => [$bakerId],
            ],
        ];

        foreach ($employees as $emp) {
            $empRoles = $emp['roles'];
            unset($emp['roles']);

            DB::table('employees')->insertOrIgnore(array_merge($emp, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            foreach ($empRoles as $roleId) {
                DB::table('employee_roles')->insertOrIgnore([
                    'employee_id' => $emp['id'],
                    'role_id'     => $roleId,
                ]);
            }
        }
    }
}