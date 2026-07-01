<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpinReward extends Model
{
    protected $fillable = [
        'user_id',
        'prize_type',
        'discount_percent',
        'coupon_code',
        'is_used',
        'expires_at',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'discount_percent' => 'decimal:2',
            'is_used' => 'boolean',
            'expires_at' => 'datetime',
            'used_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if this reward is still valid for use.
     */
    public function isValid(): bool
    {
        return !$this->is_used && $this->expires_at->isFuture();
    }
}
