<?php

namespace NotificationChannels\Apn;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Pushok\AuthProvider\Certificate;
use Pushok\Client;

class ApnServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Certificate::class, function ($app) {
            $options = Arr::except($app['config']['broadcasting.connections.apn'], 'production');

            return Certificate::create($options);
        });

        $this->app->bind(Client::class, function ($app) {
            return new Client($app->make(Certificate::class), $app['config']['broadcasting.connections.apn.production']);
        });
    }
}
