<?php

namespace Masterix21\LaravelCart\Tests;

use Masterix21\LaravelCart\Cart;
use Masterix21\LaravelCart\Models\CartItem;
use Masterix21\LaravelCart\Order;
use Masterix21\LaravelCart\Tests\TestClasses\Product;

class CartTest extends TestCase
{
    /** @test */
    public function it_generates_random_cart_uuid(): void
    {
        $uuid = Cart::uuid();

        $this->assertNotEmpty($uuid);

        $this->assertEquals($uuid, Cart::uuid());
    }

    /** @test */
    public function it_add_item_to_cart(): void
    {
        $product1 = Product::factory()->count(1)->createOne();
        $product2 = Product::factory()->count(1)->createOne();

        $cartItem1 = Cart::add(label: $product1->name, item: $product1, price: $product1->price);
        $cartItem2 = Cart::add(label: $product2->name, item: $product2, price: $product2->price);

        $this->assertTrue($cartItem1->exists);
        $this->assertTrue($cartItem2->exists);

        $this->assertEquals($cartItem1->cart_uuid, Cart::uuid());
        $this->assertEquals($cartItem1->cart_uuid, $cartItem2->cart_uuid);

        $this->assertEquals($cartItem1->price, $product1->price);
        $this->assertEquals($cartItem2->price, $product2->price);
    }

    /** @test */
    public function it_increase_the_quantity(): void
    {
        $product = Product::factory()->count(1)->createOne();

        $cartItem = Cart::add(label: $product->name, item: $product, price: $product->price);
        $this->assertEquals(1, $cartItem->quantity);

        Cart::increase($cartItem);
        $this->assertEquals(2, $cartItem->quantity);

        Cart::increase($cartItem, 5);
        $this->assertEquals(7, $cartItem->quantity);
    }

    /** @test */
    public function it_decrease_the_quantity(): void
    {
        $product = Product::factory()->count(1)->createOne();

        $cartItem = Cart::add(label: $product->name, item: $product, price: $product->price, quantity: 5);
        $this->assertEquals(5, $cartItem->quantity);

        Cart::decrease($cartItem);
        $this->assertEquals(4, $cartItem->quantity);

        Cart::decrease($cartItem, 4);
        $this->assertFalse($cartItem->exists);
    }

    /** @test */
    public function it_set_the_specified_quantity(): void
    {
        $product = Product::factory()->count(1)->createOne();

        $cartItem = Cart::add(label: $product->name, item: $product, price: $product->price, quantity: 10);
        $this->assertEquals(10, $cartItem->quantity);

        Cart::set($cartItem, 5);
        $this->assertEquals(5, $cartItem->quantity);
    }

    /** @test */
    public function it_remove_a_cart_item(): void
    {
        $product1 = Product::factory()->count(1)->createOne();
        $product2 = Product::factory()->count(1)->createOne();

        $cartItem1 = Cart::add(label: $product1->name, item: $product1, price: $product1->price, quantity: 21);
        $cartItem2 = Cart::add(label: $product2->name, item: $product2, price: $product2->price, quantity: 2);

        $this->assertEquals(2, CartItem::where('cart_uuid', Cart::uuid())->count());

        Cart::remove($cartItem1);

        $this->assertFalse($cartItem1->exists);
        $this->assertTrue($cartItem2->exists);
        $this->assertEquals(1, CartItem::where('cart_uuid', Cart::uuid())->count());
    }

    /** @test */
    public function it_clear_the_cart(): void
    {
        Product::factory()
            ->count(2)
            ->create()
            ->each(fn (Product $p) => Cart::add(label: $p->name, item: $p, price: $p->price, quantity: 21));

        $this->assertEquals(2, CartItem::where('cart_uuid', Cart::uuid())->count());

        Cart::clear();

        $this->assertEquals(0, CartItem::where('cart_uuid', Cart::uuid())->count());
    }

    /** @test */
    public function it_retrieve_the_items(): void
    {
        Product::factory()
            ->count(3)
            ->create()
            ->each(fn (Product $product) => Cart::add(label: $product->name, item: $product, price: $product->price));

        $this->assertCount(3, Cart::items());
    }

    /** @test */
    public function verify_if_the_cart_is_empty(): void
    {
        Cart::clear();

        $this->assertTrue(Cart::isEmpty());
        $this->assertFalse(Cart::isNotEmpty());
    }

    /** @test */
    public function verify_if_the_cart_is_not_empty(): void
    {
        $product = Product::factory()->count(1)->createOne();
        Cart::add(label: $product->name, item: $product, price: $product->price);

        $this->assertFalse(Cart::isEmpty());
        $this->assertTrue(Cart::isNotEmpty());
    }

    /** @test  */
    public function it_convert_cart_item_to_order(): void
    {
        $product = Product::factory()
            ->count(3)
            ->create()
            ->each(fn (Product $product) => Cart::add(label: $product->name, item: $product, price: $product->price));

        $order = Order::create(cartItem: Cart::items(), price: $product->first()->price);

        $this->assertTrue($order->exists);
    }
}
