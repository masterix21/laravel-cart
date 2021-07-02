<?php


namespace Masterix21\LaravelCart\Models;


use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $casts = [
        'price' => MoneyCast::class,
        'shipment_costs' => MoneyCast::class,
        'taxes' => MoneyCast::class,
        'discount' => MoneyCast::class,
        'total' => MoneyCast::class,
        'confirmed_at' => 'datetime',
        'refused_at' => 'datetime',
        'paid_at' => 'datetime',
        'payment_confirmed_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('cart.models.user'), 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
