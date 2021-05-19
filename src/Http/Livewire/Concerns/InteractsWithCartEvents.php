<?php

namespace Masterix21\LaravelCart\Http\Livewire\Concerns;

use Livewire\Component;
use Masterix21\LaravelCart\Models\CartItem;

/** @mixin Component */
trait InteractsWithCartEvents
{
    public function cartItemAdded(?CartItem $item = null): void
    {
        $this->emit('cart::item-added', $item->id);
    }

    public function cartItemRemoved(?CartItem $item = null): void
    {
        $this->emit('cart::item-removed', $item->id);
    }

    public function cartItemChanged(?CartItem $item = null): void
    {
        $this->emit('cart::item-changed', $item->id);
    }

    public function cartCleared(): void
    {
        $this->emit('cart::cleared');
    }
}
