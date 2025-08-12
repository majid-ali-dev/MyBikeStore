<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'brand_id',
        'total_amount',
        'status',
        'payment_status',
        'advance_payment',
        'shipping_address',
        'notes',
        'color',
        'expected_completion_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function brand()
    {
       return $this->belongsTo(Bike::class, 'brand_id');
    }
}
