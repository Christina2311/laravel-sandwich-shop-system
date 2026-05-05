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
        //    Chrisha  → Manager  (has a user account, not an employee)
        //    Christina Yute → Seller & Baker (employee #5)
        //    Tom Baker      → Baker only     (employee #3 user account)
        //    Alex Both      → Seller & Baker (employee #6)
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

        // Link users to their roles (role_user pivot — adjust table name if different)
        // Manager
        DB::table('role_user')->insertOrIgnore([
            ['user_id' => 1, 'role_id' => $managerId],
        ]);
        // Seller & Baker (Christina)
        DB::table('role_user')->insertOrIgnore([
            ['user_id' => 2, 'role_id' => $sellerId],
            ['user_id' => 2, 'role_id' => $bakerId],
        ]);
        // Baker only (Tom)
        DB::table('role_user')->insertOrIgnore([
            ['user_id' => 3, 'role_id' => $bakerId],
        ]);
        // Seller & Baker (Alex)
        DB::table('role_user')->insertOrIgnore([
            ['user_id' => 4, 'role_id' => $sellerId],
            ['user_id' => 4, 'role_id' => $bakerId],
        ]);


        // ══════════════════════════════════════════════════
        // 3. EMPLOYEES
        //    Matches the employees table from the screenshot
        // ══════════════════════════════════════════════════
        $employees = [
            [
                'id'            => 1,
                'employee_fn'   => 'Maria',
                'employee_ln'   => 'Reyes',
                'e_barangay'    => 'Barangay 1',
                'e_city'        => 'Quezon City',
                'e_contact_info'=> '09171234567',
                'is_active'     => 1,
                'roles'         => [$sellerId],          // Seller
            ],
            [
                'id'            => 2,
                'employee_fn'   => 'Juan',
                'employee_ln'   => 'dela Cruz',
                'e_barangay'    => 'Barangay 2',
                'e_city'        => 'Quezon City',
                'e_contact_info'=> '09182345678',
                'is_active'     => 1,
                'roles'         => [$bakerId],           // Baker
            ],
            [
                'id'            => 3,
                'employee_fn'   => 'Pedro',
                'employee_ln'   => 'Santos',
                'e_barangay'    => 'Barangay 3',
                'e_city'        => 'Quezon City',
                'e_contact_info'=> '09193456789',
                'is_active'     => 1,
                'roles'         => [$sellerId],          // Seller
            ],
            [
                'id'            => 4,
                'employee_fn'   => 'Rosa',
                'employee_ln'   => 'Bautista',
                'e_barangay'    => 'Barangay 4',
                'e_city'        => 'Quezon City',
                'e_contact_info'=> '09204567890',
                'is_active'     => 1,
                'roles'         => [$bakerId],           // Baker
            ],
            [
                'id'            => 5,
                'employee_fn'   => 'Christina',
                'employee_ln'   => 'Yute',
                'e_barangay'    => 'Barangay 5',
                'e_city'        => 'Quezon City',
                'e_contact_info'=> '09215678901',
                'is_active'     => 1,
                'roles'         => [$sellerId, $bakerId], // Seller & Baker
            ],
            [
                'id'            => 6,
                'employee_fn'   => 'Alex',
                'employee_ln'   => 'Both',
                'e_barangay'    => 'Barangay 6',
                'e_city'        => 'Quezon City',
                'e_contact_info'=> '09226789012',
                'is_active'     => 1,
                'roles'         => [$sellerId, $bakerId], // Seller & Baker
            ],
        ];

        foreach ($employees as $emp) {
            $empRoles = $emp['roles'];
            unset($emp['roles']);

            DB::table('employees')->insertOrIgnore(array_merge($emp, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            // Link employee to their role(s) in pivot table
            foreach ($empRoles as $roleId) {
                DB::table('employee_roles')->insertOrIgnore([
                    'employee_id' => $emp['id'],
                    'role_id'     => $roleId,
                ]);
            }
        }
    }
}