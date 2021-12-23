<?php

namespace Masterix21\LaravelCart\Models;

use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'amount' => MoneyCast::class,
        'refused_at' => 'datetime',
        'paid_at' => 'datetime',
        'payment_confirmed_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(config('cart.models.order'), 'order_id');
    }
}
