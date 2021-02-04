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
            $credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));

            return Route53Client::factory([
                'credentials' => $credentials,
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
