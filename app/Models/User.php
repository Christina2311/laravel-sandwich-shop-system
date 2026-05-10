<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Fetch the linked Employee record by matching the user's name
     * against employee_fn + employee_ln (no user_id FK in employees table).
     * Usage: auth()->user()->employee  or  Auth::user()->employee
     */
    public function getEmployeeAttribute(): ?\App\Models\Employee
    {
        $parts = explode(' ', trim($this->name), 2);
        $fn    = $parts[0] ?? '';
        $ln    = $parts[1] ?? '';

        return \App\Models\Employee::where('employee_fn', $fn)
                                   ->where('employee_ln', $ln)
                                   ->first();
    }

    /**
     * Check whether the user has a given role.
     * Case-insensitive, works with the many-to-many relationship.
     *
     * @param  string  $role  e.g. 'manager', 'seller', 'baker'
     */
    public function hasRole(string $role): bool
    {
        return $this->roles()
                    ->where('role_name', strtolower(trim($role)))
                    ->exists();
    }

    /**
     * Convenience accessors – true if the user has that specific role.
     * Useful in Blade:  @if(auth()->user()->isManager())
     */
    public function isManager(): bool { return $this->hasRole('manager'); }
    public function isSeller():  bool { return $this->hasRole('seller');  }
    public function isBaker():   bool { return $this->hasRole('baker');   }

    /**
     * Returns true when the employee can access the Baker dashboard
     * (is a baker, regardless of whether they are also a seller).
     */
    public function canAccessBakerDashboard(): bool { return $this->isBaker(); }

    /**
     * Returns true when the employee can access the Seller dashboard.
     */
    public function canAccessSellerDashboard(): bool { return $this->isSeller(); }
}