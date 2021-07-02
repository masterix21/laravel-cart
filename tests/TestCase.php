<?php

namespace Masterix21\LaravelCart\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Masterix21\LaravelCart\CartServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Masterix21\\LaravelCart\\Tests\\database\\factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            CartServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        include_once __DIR__ . '/database/migrations/create_products_table.php';
        (new \CreateProductsTable())->up();

        include_once __DIR__.'/../database/migrations/create_cart_items_table.php.stub';
        (new \CreateCartItemsTable())->up();

        include_once __DIR__.'/../database/migrations/create_orders_table.php.stub';
        (new \CreateOrdersTable())->up();

        include_once __DIR__.'/../database/migrations/create_order_items_table.php.stub';
        (new \CreateOrderItemsTable())->up();
    }
}
