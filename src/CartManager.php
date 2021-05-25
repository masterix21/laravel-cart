<?php

namespace Masterix21\LaravelCart;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Masterix21\LaravelCart\Models\CartItem;

class CartManager
{
    public function __construct(public ?string $cartUuid = null)
    {
        // ...
    }

    public function uuid(): string
    {
        $uuid = $this->cartUuid
            ?? session()->get('cart-uuid')
            ?? request()->cookie('cart-uuid')
            ?? (string) Str::uuid();

        if (! $this->cartUuid) {
            $this->cartUuid = $uuid;

            session(['cart-uuid' => $uuid]);
            cookie('cart-uuid', $uuid);
        }

        return $uuid;
    }

    public function invalidateCache(): void
    {
        Cache::store(config('cart.cache'))->forget('cart-'. $this->uuid() .'-items');
        Cache::store(config('cart.cache'))->forget('cart-'. $this->uuid() .'-count');
    }

    public function add(
        string $label,
        Model $item,
        int $quantity = 1,
        ?string $unit = null,
        $price = 0,
        $taxes = 0,
        ?string $taxesLabel = null,
        ?string $description = null,
        ?array $meta = null,
    ): CartItem
    {
        $this->invalidateCache();

        return CartItem::create([
            'cart_uuid' => $this->uuid(),
            'user_id' => auth()->id(),
            'label' => $label,
            'description' => $description,
            'item_type' => $item::class,
            'item_id' => $item->id,
            'price' => $price,
            'quantity' => $quantity,
            'unit' => $unit,
            'taxes' => $taxes,
            'taxes_label' => $taxesLabel,
            'meta' => $meta,
        ]);
    }

    public function search(Model $model): Collection
    {
        return $this->items()
            ->filter(fn (CartItem $cartItem) => $cartItem->item_type === $model::class
                && $cartItem->item_id === $model->getKey());
    }

    public function set(CartItem $cartItem, int $quantity): CartItem
    {
        $this->invalidateCache();

        return $cartItem->setQuantity($quantity);
    }

    public function increase(CartItem $cartItem, int $quantity = 1): CartItem
    {
        $this->invalidateCache();

        return $cartItem->increase($quantity);
    }

    public function decrease(CartItem $cartItem, int $quantity = 1): ?CartItem
    {
        $this->invalidateCache();

        return $cartItem->decrease($quantity);
    }

    public function remove(CartItem $cartItem): bool|null
    {
        $this->invalidateCache();

        return $cartItem->delete();
    }

    public function query(): Builder
    {
        return CartItem::query()->where('cart_uuid', $this->uuid());
    }

    public function clear(): void
    {
        $this->invalidateCache();

        $this->query()
            ->when(auth()->check(), fn ($query) => $query->orWhere('user_id', auth()->id()))
            ->delete();
    }

    public function items(): array|Collection
    {
        return Cache::store(config('cart.cache'))
            ->remember(
                key: 'cart-'. $this->uuid() .'-items',
                ttl: 3600,
                callback: fn () => $this->query()
                    ->when(auth()->check(), fn ($query) => $query->orWhere('user_id', auth()->id()))
                    ->get()
            );
    }

    public function count(): int
    {
        return Cache::store(config('cart.cache'))
            ->remember(
                key: 'cart-'. $this->uuid() .'-count',
                ttl: 3600,
                callback: fn () => $this->query()->count()
            );
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function isNotEmpty(): bool
    {
        return $this->count() > 0;
    }

    public function contains(Model $model): bool
    {
        return $this->items()
            ->where('item_type', $model::class)
            ->where('item_id', $model->id)
            ->count() > 0;
    }
}
