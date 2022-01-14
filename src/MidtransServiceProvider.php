<?php

namespace Sawirricardo\Midtrans;

use Illuminate\Support\Facades\Blade;
use Sawirricardo\Midtrans\Commands\MidtransCommand;
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

    public function register()
    {
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$clientKey = config('midtrans.client_key');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
        \Midtrans\Config::$appendNotifUrl = config('midtrans.append_notif_url');
        \Midtrans\Config::$overrideNotifUrl = config('midtrans.overrideNotifUrl');
        \Midtrans\Config::$paymentIdempotencyKey = config('midtrans.payment_idempotency_key');
        \Midtrans\Config::$curlOptions = config('midtrans.curl_options');
    }

    public function boot()
    {
        Blade::directive('midtransSnapScripts', function ($expression) {
            return "{!! \Sawirricardo\Midtrans::snapScripts($expression) !!}";
        });

        Blade::directive('midtransCardScripts', function ($expression) {
            return "{!! \Sawirricardo\Midtrans::cardScripts($expression) !!}";
        });
    }
}
