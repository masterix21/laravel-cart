<?php

namespace Masterix21\LaravelCart\Http\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Masterix21\LaravelCart\Cart;
use Masterix21\LaravelCart\Http\Livewire\Concerns\InteractsWithCartEvents;
use Masterix21\LaravelCart\Http\Livewire\Concerns\RefreshOnCartEvents;
use Masterix21\LaravelCart\Models\CartItem;

class Items extends Component
{
    use RefreshOnCartEvents;
    use InteractsWithCartEvents;

    public function render()
    {
        return view('cart::livewire.items');
    }

    public function getCartItemsProperty(): Collection
    {
        return Cart::items();
    }

    public function removeItem($id): void
    {
        $item = CartItem::find($id);

        Cart::remove($item);

        $this->cartItemRemoved($item);
    }
}
