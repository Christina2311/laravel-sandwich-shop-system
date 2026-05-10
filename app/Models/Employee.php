<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_fn',
        'employee_ln',
        'e_barangay',
        'e_city',
        'e_contact_info',
        'is_active',
        'email',
        'password',
    ];

    protected $hidden = ['password'];

    // Accessor: $employee->name => "John Doe"
    public function getNameAttribute(): string
    {
        return $this->employee_fn . ' ' . $this->employee_ln;
    }

    // Accessor: $employee->address => "Brgy. X, Quezon City"
    public function getAddressAttribute(): string
    {
        return trim($this->e_barangay . ', ' . $this->e_city, ', ');
    }

    // Accessor: $employee->status => "active" / "inactive"
    public function getStatusAttribute(): string
    {
        return $this->is_active ? 'active' : 'inactive';
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'employee_roles');
    }
}