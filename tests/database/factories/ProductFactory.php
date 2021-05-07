<?php

namespace Masterix21\LaravelCart\Tests\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Masterix21\LaravelCart\Tests\TestClasses\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->text(90),
            'price' => $this->faker->randomFloat(),
        ];
    }
}
