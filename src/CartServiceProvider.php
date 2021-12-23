<?php

namespace Masterix21\LaravelCart;

use Livewire\Livewire;
use Masterix21\LaravelCart\Http\Livewire\Counter;
use Masterix21\LaravelCart\Http\Livewire\Items;
use Masterix21\LaravelCart\View\IconDropdown;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CartServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('cart')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasViews()
            ->hasViewComponents('cart', IconDropdown::class)
            ->hasMigrations([
                'create_cart_items_table',
                'create_orders_table',
                'create_order_items_table',
                'create_payments_table'
            ]);

        $this->app->singleton('cart', fn () => new CartManager());
        $this->app->singleton('order', fn () => new OrderManager());
    }

    public function packageBooted(): void
    {
        $this->loadJsonTranslationsFrom($this->package->basePath('/../resources/lang/'));
        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/'. $this->package->name));

        $this->registerLivewireComponents();
    }

    public function registerLivewireComponents(): self
    {
        if (class_exists(Livewire::class)) {
            Livewire::component('cart-counter', Counter::class);
            Livewire::component('cart-items', Items::class);
        }

        return $this;
    }
}
