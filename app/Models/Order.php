<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'seller_id',
        'baker_id',
        'status',
        'total_amount',
        'subtotal',
        'tax',
        'order_date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function seller()
    {
        return $this->belongsTo(Employee::class, 'seller_id');
    }

    public function baker()
    {
        return $this->belongsTo(Employee::class, 'baker_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}