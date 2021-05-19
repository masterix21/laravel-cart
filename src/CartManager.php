<?php

namespace Masterix21\LaravelCart;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Masterix21\LaravelCart\Models\CartItem;

class CartManager
{
    public function __construct(
        public ?string $cartUuid = null
    )
    {
    }

    public function uuid(): string
    {
        if (blank($this->cartUuid)) {
            $this->cartUuid ??= session('cart-uuid')
                ?? Cookie::get('cart-uuid')
                ?? (string) Str::uuid();

            session(['cart-uuid' => $this->cartUuid]);
            cookie('cart-uuid', $this->cartUuid);
        }

        return $this->cartUuid;
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

    public function set(CartItem $cartItem, int $quantity): CartItem
    {
        return $cartItem->setQuantity($quantity);
    }

    public function increase(CartItem $cartItem, int $quantity = 1): CartItem
    {
        return $cartItem->increase($quantity);
    }

    public function decrease(CartItem $cartItem, int $quantity = 1): ?CartItem
    {
        return $cartItem->decrease($quantity);
    }

    public function remove(CartItem $cartItem): bool
    {
        return $cartItem->delete();
    }

    public function query(): Builder
    {
        return CartItem::query()->where('cart_uuid', $this->uuid());
    }

    public function clear(): void
    {
        $this->query()
            ->when(auth()->check(), fn ($query) => $query->orWhere('user_id', auth()->id()))
            ->delete();
    }

    public function items(): Collection
    {
        return $this->query()
            ->when(auth()->check(), fn ($query) => $query->orWhere('user_id', auth()->id()))
            ->get();
    }

    public function isEmpty(): bool
    {
        return $this->query()->count() === 0;
    }

    public function isNotEmpty(): bool
    {
        return $this->query()->count() > 0;
    }
}
