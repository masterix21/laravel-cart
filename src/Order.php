<?php

namespace Masterix21\LaravelCart;

use Illuminate\Support\Facades\Facade;

class Order extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'order';
    }
}
