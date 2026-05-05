<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = [
        'employee_id',
        'product_id',
        'quantity',
        'supplier',
        'date',
        'note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}