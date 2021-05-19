<?php

namespace Masterix21\LaravelCart\Http\Livewire;

use Livewire\Component;
use Masterix21\LaravelCart\Cart;
use Masterix21\LaravelCart\Http\Livewire\Concerns\RefreshOnCartEvents;

class Counter extends Component
{
    use RefreshOnCartEvents;

    public ?int $count = null;
    public string|array|null $class = null;
    public string|array|null $emptyClass = null;
    public string|array|null $notEmptyClass = null;

    public function render()
    {
        return view('cart::livewire.counter');
    }

    public function getCounterProperty(): int
    {
        return $this->count ?? Cart::count();
    }

    public function getClassesProperty(): string
    {
        $class = collect($this->class);

        if (Cart::isEmpty()) {
            return $class->merge(collect($this->emptyClass))->join(' ');
        }

        return $class->merge(collect($this->notEmptyClass))->join(' ');
    }
}
