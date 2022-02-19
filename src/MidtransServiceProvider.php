<?php

namespace Sawirricardo\Midtrans\Laravel;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Sawirricardo\Midtrans\Laravel\Midtrans;

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
            return Midtrans::makeFromConfig($app['config']->get('midtrans'));
        });
    }

    public function boot()
    {
        Blade::directive('midtransSnapScripts', function ($expression) {
            return "{!! \Sawirricardo\Midtrans\Laravel\Midtrans::snapScripts($expression) !!}";
        });

        Blade::directive('midtransCardScripts', function ($expression) {
            return "{!! \Sawirricardo\Midtrans\Laravel\Midtrans::cardScripts($expression) !!}";
        });
    }
}
