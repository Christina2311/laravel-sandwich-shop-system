<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockInRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'product_id',
        'quantity',
        'supplier',
        'date',
        'note',
        'status',
        'manager_note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}