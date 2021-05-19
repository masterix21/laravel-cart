# Cart integration for any Laravel Project

[![Latest Version on Packagist](https://img.shields.io/packagist/v/masterix21/laravel-cart.svg?style=flat-square)](https://packagist.org/packages/masterix21/laravel-cart)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/masterix21/laravel-cart/run-tests?label=tests)](https://github.com/masterix21/laravel-cart/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/masterix21/laravel-cart/Check%20&%20fix%20styling?label=code%20style)](https://github.com/masterix21/laravel-cart/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/masterix21/laravel-cart.svg?style=flat-square)](https://packagist.org/packages/masterix21/laravel-cart)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require masterix21/laravel-cart
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Masterix21\LaravelCart\CartServiceProvider" --tag="laravel-cart-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Masterix21\LaravelCart\CartServiceProvider" --tag="laravel-cart-config"
```

## Usage

```php
$product = YourProductModel::first();

//
// Add a product to cart
$cartItem = Cart::add(label: $product->name, item: $product, price: $product->price, quantity: 1);

//
// Change the cart item quantity
Cart::set($cartItem, 2); // or
$cartItem->setQuantity(2);

//
// Increase the cart item quantity
Cart::increase($cartItem); // to increase of 1
Cart::increase($cartItem, 5); // to increase of 5
$cartItem->increase(); // to increase of 1
$cartItem->increase(5); // to increase of 5

//
// Decrease the cart item quantity, and if the
// quantity is zero, removes the item from the cart.
Cart::decrease($cartItem); // to decrease of 1
Cart::decrease($cartItem, 5); // to decrease of 5
$cartItem->decrease(); // to decrease of 1
$cartItem->decrease(5); // to decrease of 5

// Retrieve all cart items
$items = Cart::items();

// Clear the cart
Cart::clear();
```

## Views using Blade
Display the cart items counter that will auto-refresh on cart changes: 
```html
<!-- Automatic refresh the counter -->
<livewire:cart-counter />

<!-- Force the displayed value -->
<livewire:cart-counter :count="10" no-auto-refresh />

<!-- Customize the component using class argument like so -->
<livewire:cart-counter class="text-xs text-white rounded-full bg-red-700" />

<!-- Improve the result by its state -->
<livewire:cart-counter class="text-xs rounded-full" 
                       empty-class="bg-gray-100 text-gray-500" 
                       not-empty-class="bg-red-700 text-white" />
```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Luca Longo](https://github.com/masterix21)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
