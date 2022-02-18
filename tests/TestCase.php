<?php

namespace Sawirricardo\MidtransClient\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Orchestra\Testbench\TestCase as Orchestra;
use Sawirricardo\MidtransClient\MidtransServiceProvider;

class TestCase extends Orchestra
{
    protected function getApplicationTimezone($app)
    {
        return 'Asia/Jakarta';
    }

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Sawirricardo\\MidtransClient\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            MidtransServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        $app->useEnvironmentPath(__DIR__ . '/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);
        parent::getEnvironmentSetUp($app);
        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-midtrans_table.php.stub';
        $migration->up();
        */
    }
}
