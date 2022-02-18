<?php

namespace Sawirricardo\MidtransClient;

use Illuminate\Support\Facades\Blade;
use Sawirricardo\MidtransClient\MidtransClient;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MidtransServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-midtrans')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        $this->app->singleton('laravel-midtrans', function ($app) {
            return MidtransClient::makeFromConfig($app['config']->get('midtrans'));
        });
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
