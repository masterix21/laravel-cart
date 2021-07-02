<?php

namespace Masterix21\LaravelCart\Models;

use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price' => MoneyCast::class,
        'taxes' => MoneyCast::class,
        'discount' => MoneyCast::class,
        'total' => MoneyCast::class,
        'meta' => AsArrayObject::class,
    ];

    public function item(): MorphTo
    {
        return $this->morphTo();
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(config('cart.models.order'), 'order_id');
    }
}
