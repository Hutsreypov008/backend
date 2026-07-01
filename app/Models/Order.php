<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'discount_amount',
        'coupon_code',
        'status',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
    ];
    protected function casts(): array
    {
        return [
            'discount_amount' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
