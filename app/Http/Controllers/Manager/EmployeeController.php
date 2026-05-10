<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('roles')->paginate(10);

        $managerCount = Employee::whereHas('roles', fn($q) => $q->where('role_name', 'Manager'))->count();
        $sellerCount  = Employee::whereHas('roles', fn($q) => $q->where('role_name', 'Seller'))->count();
        $bakerCount   = Employee::whereHas('roles', fn($q) => $q->where('role_name', 'Baker'))->count();

        return view('manager.employeemanagement.index', compact(
            'employees', 'managerCount', 'sellerCount', 'bakerCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_fn'    => 'required|string|max:255',
            'employee_ln'    => 'required|string|max:255',
            'e_barangay'     => 'nullable|string|max:255',
            'e_city'         => 'nullable|string|max:255',
            'e_contact_info' => 'nullable|string|max:20',
            'role'           => 'required|string',
            'is_active'      => 'required|boolean',
        ]);

        $employee = Employee::create([
            'employee_fn'    => $request->employee_fn,
            'employee_ln'    => $request->employee_ln,
            'e_barangay'     => $request->e_barangay,
            'e_city'         => $request->e_city,
            'e_contact_info' => $request->e_contact_info,
            'is_active'      => $request->is_active,
        ]);

        $employee->roles()->sync($this->resolveRoleIds($request->role));

        return redirect()->route('manager.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'employee_fn'    => 'required|string|max:255',
            'employee_ln'    => 'required|string|max:255',
            'e_barangay'     => 'nullable|string|max:255',
            'e_city'         => 'nullable|string|max:255',
            'e_contact_info' => 'nullable|string|max:20',
            'role'           => 'required|string',
            'is_active'      => 'required|boolean',
        ]);

        $employee->update([
            'employee_fn'    => $request->employee_fn,
            'employee_ln'    => $request->employee_ln,
            'e_barangay'     => $request->e_barangay,
            'e_city'         => $request->e_city,
            'e_contact_info' => $request->e_contact_info,
            'is_active'      => $request->is_active,
        ]);

        $employee->roles()->sync($this->resolveRoleIds($request->role));

        return redirect()->route('manager.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function archive($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update(['is_active' => false]);

        return redirect()->route('manager.employees.index')
            ->with('success', 'Employee archived successfully.');
    }

    /**
     * Maps form role string to an array of role IDs.
     * Handles "Seller & Baker" as two separate roles.
     */
    private function resolveRoleIds(string $roleString): array
    {
        $map = [
            'Manager'        => ['Manager'],
            'Seller'         => ['Seller'],
            'Baker'          => ['Baker'],
            'Seller & Baker' => ['Seller', 'Baker'],
        ];

        $names = $map[$roleString] ?? [$roleString];

        return Role::whereIn('role_name', $names)->pluck('id')->toArray();
    }
}