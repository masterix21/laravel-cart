<?php

namespace Masterix21\LaravelCart\Http\Livewire\Concerns;

use Livewire\Component;

/** @mixin Component */
trait RefreshOnCartEvents
{
    public bool $noAutoRefresh = false;

    public function getListeners(): array
    {
        $listeners = $this->noAutoRefresh
            ? []
            : [
                'cart::item-added' => '$refresh',
                'cart::item-removed' => '$refresh',
                'cart::item-changed' => '$refresh',
                'cart::cleared' => '$refresh',
            ];

        return array_merge($listeners, $this->listeners);
    }
}
