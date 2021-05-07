<?php

namespace Masterix21\LaravelCart;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Masterix21\LaravelCart\LaravelCart
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cart';
    }
}
