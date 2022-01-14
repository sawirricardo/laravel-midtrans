<?php

namespace Sawirricardo\Midtrans;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MidtransServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-midtrans')
            ->hasConfigFile();
    }

    public function boot()
    {
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        if (config('midtrans.is_production')) {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$clientKey = config('midtrans.client_key');
        } else {
            \Midtrans\Config::$serverKey = config('midtrans.sandbox_server_key');
            \Midtrans\Config::$clientKey = config('midtrans.sandbox_client_key');
        }
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized', true);
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds', true);
        if (!is_null(config('midtrans.append_notif_url'))) {
            \Midtrans\Config::$isProduction = config('midtrans.append_notif_url');
        }
        if (!is_null(config('midtrans.overrideNotifUrl'))) {
            \Midtrans\Config::$overrideNotifUrl = config('midtrans.overrideNotifUrl');
        }
        if (!is_null(config('midtrans.payment_idempotency_key'))) {
            \Midtrans\Config::$paymentIdempotencyKey = config('midtrans.payment_idempotency_key');
        }
        if (!is_null(config('midtrans.curl_options'))) {
            \Midtrans\Config::$curlOptions = config('midtrans.curl_options');
        }

        Blade::directive('midtransSnapScripts', function ($expression) {
            return "{!! \Sawirricardo\Midtrans::snapScripts($expression) !!}";
        });

        Blade::directive('midtransCardScripts', function ($expression) {
            return "{!! \Sawirricardo\Midtrans::cardScripts($expression) !!}";
        });
    }
}
