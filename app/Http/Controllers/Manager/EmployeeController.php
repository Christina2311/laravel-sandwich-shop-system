<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        // Eager load roles and paginate 10 per page
        $employees = Employee::with('roles')->paginate(10);

        // Ensure role names match exactly ('Manager' vs 'manager')[cite: 4, 9]
        $managerCount = Employee::whereHas('roles', function($q) {
            $q->where('role_name', 'Manager');
        })->count();

        $sellerCount = Employee::whereHas('roles', function($q) {
            $q->where('role_name', 'Seller');
        })->count();

        $bakerCount = Employee::whereHas('roles', function($q) {
            $q->where('role_name', 'Baker');
        })->count();

        return view('manager.employeemanagement.index', compact(
            'employees', 'managerCount', 'sellerCount', 'bakerCount'
        ));
    }

    // ARCHIVE LOGIC: Updates is_active column instead of deleting[cite: 3, 9]
    public function archive($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update(['is_active' => false]);

        return redirect()->route('manager.employees.index')->with('success', 'Employee archived successfully.');
    }
}