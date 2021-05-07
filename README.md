# Cart integration for any Laravel Project

[![Latest Version on Packagist](https://img.shields.io/packagist/v/masterix21/laravel_cart.svg?style=flat-square)](https://packagist.org/packages/masterix21/laravel_cart)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/masterix21/laravel_cart/run-tests?label=tests)](https://github.com/masterix21/laravel_cart/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/masterix21/laravel_cart/Check%20&%20fix%20styling?label=code%20style)](https://github.com/masterix21/laravel_cart/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/masterix21/laravel_cart.svg?style=flat-square)](https://packagist.org/packages/masterix21/laravel_cart)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require masterix21/laravel-cart
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Masterix21\LaravelCart\LaravelCartServiceProvider" --tag="laravel-cart-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Masterix21\LaravelCart\LaravelCartServiceProvider" --tag="laravel-cart-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravel_cart = new Masterix21\LaravelCart();
echo $laravel_cart->echoPhrase('Hello, Spatie!');
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
