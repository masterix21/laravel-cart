<?php

namespace Masterix21\LaravelCart\Models;

use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property mixed|string label
 * @property mixed|string description
 * @property array|mixed  meta
 * @property mixed|string price
 */
class CartItem extends Model
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

    protected static function boot()
    {
        parent::boot();

        static::saving(static function (CartItem $cartItem) {
            $cartItem->total = $cartItem->price
                ->multiply($cartItem->quantity ?? money(1))
                ->subtract($cartItem->discount ?? money(0));

            return $cartItem;
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('cart.models.user'), 'user_id');
    }

    public function item(): MorphTo
    {
        return $this->morphTo();
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        $this->save();

        return $this;
    }

    public function increase(int $quantity = 1): self
    {
        $this->quantity += $quantity;
        $this->save();

        return $this;
    }

    public function decrease(int $quantity = 1): ?self
    {
        if (($this->quantity - $quantity) <= 0) {
            $this->delete();

            return null;
        }

        $this->quantity -= $quantity;
        $this->save();

        return $this;
    }
}
