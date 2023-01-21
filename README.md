# 🚀 Laravel Midtrans - Wrapper for Midtrans package

![Laravel Midtrans](https://banners.beyondco.de/laravel-midtrans.png?theme=light&packageManager=composer+require&packageName=sawirricardo%2Flaravel-midtrans&pattern=bankNote&style=style_1&description=Use+Midtrans+Payment+Gateway+in+your+laravel+apps&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/sawirricardo/laravel-midtrans.svg?style=flat-square)](https://packagist.org/packages/sawirricardo/laravel-midtrans)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/sawirricardo/laravel-midtrans/run-tests?label=tests)](https://github.com/sawirricardo/laravel-midtrans/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/sawirricardo/laravel-midtrans/Check%20&%20fix%20styling?label=code%20style)](https://github.com/sawirricardo/laravel-midtrans/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sawirricardo/laravel-midtrans.svg?style=flat-square)](https://packagist.org/packages/sawirricardo/laravel-midtrans)

In need of using Midtrans in your Laravel app? Use this package.

## Support us

We invest a lot of resources into creating [best in class open source packages](https://github.com/sawirricardo). You can support by donating to

-   [Paypal](https://paypal.me/sawirricardo)
-   Wallet 0x3F20d326E5DA8ab6D27d9b2DdD350baB1e589d87
-   BCA 8330123584

I appreciate you if you connect with me on [Twitter](https://twitter.com/RicardoSawir)

## Installation

You can install the package via composer:

```bash
composer require sawirricardo/laravel-midtrans
```

<!-- You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-midtrans-migrations"
php artisan migrate
``` -->

You can publish the config file with:

```bash
php artisan vendor:publish --tag="midtrans-config"
```

This is the contents of the published config file:

```php
return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    'sandbox_server_key' => env('MIDTRANS_SB_SERVER_KEY'),
    'sandbox_client_key' => env('MIDTRANS_SB_CLIENT_KEY'),

    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => true,
    'is_3ds' => true,

    'append_notif_url' => null,
    'overrideNotifUrl' => null,
    'payment_idempotency_key' => null,

    'curl_options' => null,
];
```

<!-- Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-midtrans-views"
``` -->

## Usage

```php
use Sawirricardo\Midtrans\Laravel\Facades\Midtrans;
$transactionToken = Midtrans::client()->snap()->create(new TransactionDto());
echo $transactionToken->token;
echo $transactionToken->redirect_url;

//checkout.blade.php
// if you use Snap, you can include Midtrans snap script
@midtransSnapScript

// if you use Core API, you will most likely need to include this.
@midtransCardScript

```

For more information of how to use Midtrans, please refer to [Midtrans documentation](https://github.com/Midtrans/midtrans-php)

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

-   [Ricardo Sawir](https://github.com/sawirricardo)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
