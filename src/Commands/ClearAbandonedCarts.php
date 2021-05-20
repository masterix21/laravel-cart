<?php

namespace Masterix21\LaravelCart\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Masterix21\LaravelCart\Models\CartItem;

class ClearAbandonedCarts extends Command
{
    protected $signature = 'cart:clear-abandoned';

    protected $description = 'Clear all carts older than 24h';

    public function handle()
    {
        CartItem::query()
            ->whereDate('created_at', '<=', now()->subDay())
            ->delete();

        Cache::store(config('cart.cache'))->flush();
    }
}
