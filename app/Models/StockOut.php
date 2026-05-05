<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $fillable = [
        'employee_id',
        'product_id',
        'quantity',
        'date',
        'reason',
        'note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}