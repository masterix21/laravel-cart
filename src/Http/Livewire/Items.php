<?php

namespace Masterix21\LaravelCart\Http\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Masterix21\LaravelCart\Cart;
use Masterix21\LaravelCart\Http\Livewire\Concerns\RefreshOnCartEvents;

class Items extends Component
{
    use RefreshOnCartEvents;

    public function render()
    {
        return view('cart::livewire.items');
    }

    public function getCartItemsProperty(): Collection
    {
        return Cart::items();
    }
}
