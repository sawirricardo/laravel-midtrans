<?php

namespace Sawirricardo\Midtrans;

use Illuminate\Support\Facades\Blade;
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
