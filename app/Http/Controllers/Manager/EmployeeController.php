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
            'name'           => 'required|string|max:255',
            'address'        => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'role'           => 'required|string',
            'status'         => 'required|string',
            'email'          => 'nullable|email|unique:employees,email',
            'password'       => 'nullable|string|min:8',
        ]);

        $employee = Employee::create([
            'name'           => $request->name,
            'address'        => $request->address,
            'contact_number' => $request->contact_number,
            'status'         => $request->status,
            'email'          => $request->email,
            'password'       => Hash::make($request->password ?? Str::random(12)),
        ]);

        $employee->roles()->sync($this->resolveRoleIds($request->role));

        return redirect()->route('manager.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:255',
            'address'        => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'role'           => 'required|string',
            'status'         => 'required|string',
        ]);

        $employee->update([
            'name'           => $request->name,
            'address'        => $request->address,
            'contact_number' => $request->contact_number,
            'status'         => $request->status,
        ]);

        $employee->roles()->sync($this->resolveRoleIds($request->role));

        return redirect()->route('manager.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function archive($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update(['status' => 'inactive']);

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
            'Manager'      => ['Manager'],
            'Seller'       => ['Seller'],
            'Baker'        => ['Baker'],
            'Seller & Baker' => ['Seller', 'Baker'],
        ];

        $names = $map[$roleString] ?? [$roleString];

        return Role::whereIn('role_name', $names)->pluck('id')->toArray();
    }
}