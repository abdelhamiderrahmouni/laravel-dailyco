<?php

namespace AbdelhamidErrahmouni\LaravelDailyco;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/dailyco.php' => config_path('dailyco.php'),
        ], 'laravel-dailyco-config');

        $this->mergeConfigFrom(__DIR__.'/../config/dailyco.php', 'dailyco');
    }

    public function register(): void
    {
        $this->app->singleton('Dailyco', function ($app) {
            return new Dailyco($app['config']->get('dailyco.token'));
        });
    }
}
