<?php

namespace Masterix21\LaravelCart;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Masterix21\LaravelCart\Models\CartItem;
use Masterix21\LaravelCart\Models\Order;
use Masterix21\LaravelCart\Models\OrderItem;

class OrderManager
{
    public function __construct(public ?string $orderUuid = null)
    {
        // ...
    }

    public function uuid(): string
    {
        $uuid = $this->orderUuid
            ?? session()->get('order-uuid')
            ?? request()->cookie('order-uuid')
            ?? (string) Str::uuid();

        if (! $this->orderUuid) {
            $this->orderUuid = $uuid;

            session(['order-uuid' => $uuid]);
            cookie('order-uuid', $uuid);
        }

        return $uuid;
    }

    public function invalidateCache(): void
    {
        Cache::store(config('cart.cache'))->forget('order-'. $this->uuid() .'-items');
        Cache::store(config('cart.cache'))->forget('order-'. $this->uuid() .'-count');
    }

    public function create(
        ?User $user = null,
        CartItem | Collection $cartItem,
        ?string $email = null,
        ?string $phone = null,
        string $paymentProvider,
        $price = 0,
        $taxes = 0,
        $shipmentCosts = 0,
        $discount = 0,
        $total = 0,
    ): Order {
        $this->invalidateCache();

        $order = Order::create([
            'order_uuid' => $this->uuid(),
            'user_id' => $user->id ?? null,
            'email' => $email,
            'phone' => $phone,
            'confirmed_at' => now(),
            'payment_provider' => $paymentProvider,
            'price' => $price,
            'shipment_costs' => $shipmentCosts,
            'taxes' => $taxes,
            'discount' => $discount,
            'total' => $total,
        ]);

        foreach ($cartItem as $item) {
            $this->addItem($order, $item);
        }

        return $order;
    }

    public function addItem(Order $order, CartItem $cartItem): OrderItem
    {
        return OrderItem::create([
            'order_id' => $order->id,
            'label' => $cartItem->label,
            'description' => $cartItem->description,
            'item_type' => $cartItem->item_type,
            'item_id' => $cartItem->item_id,
            'price' => $cartItem->price,
            'quantity' => $cartItem->quantity,
            'unit' => $cartItem->unit,
            'taxes' => $cartItem->taxes,
            'taxes_label' => $cartItem->taxes_label,
            'meta' => $cartItem->meta,
        ]);
    }
}
