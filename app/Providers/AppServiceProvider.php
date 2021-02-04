<?php

namespace App\Providers;

use Aws\Credentials\Credentials;
use Aws\Route53\Route53Client;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(Route53Client::class, function () {
            return Route53Client::factory([
                'region' => 'us-east-1',
                'version' => 'latest'
            ]);
        });
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
