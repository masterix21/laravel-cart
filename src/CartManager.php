<?php

namespace Masterix21\LaravelCart;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Masterix21\LaravelCart\Models\CartItem;

class CartManager
{
    public function __construct(
        public ?string $cartUuid = null
    )
    {
        $this->cartUuid ??= session('cart-uuid') ?? cookie('cart-uuid');

        if (blank($this->cartUuid)) {
            $this->cartUuid = (string) Str::uuid();

            session(['cart-uuid' => $this->cartUuid]);
            cookie('cart-uuid', $this->cartUuid);
        }
    }

    public function uuid(): string
    {
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
            'cart_uuid' => $this->cartUuid,
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

    public function clear(): void
    {
        CartItem::query()
            ->where('cart_uuid', $this->cartUuid)
            ->when(auth()->check(), fn ($query) => $query->orWhere('user_id', auth()->id()))
            ->delete();
    }

    public function items(): Collection
    {
        return CartItem::query()
            ->where('cart_uuid', $this->cartUuid)
            ->when(auth()->check(), fn ($query) => $query->orWhere('user_id', auth()->id()))
            ->get();
    }
}
