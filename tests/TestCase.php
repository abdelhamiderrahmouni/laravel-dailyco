<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Tests;

use AbdelhamidErrahmouni\LaravelDailyco\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('dailyco.token', 'test-api-key');
        $app['config']->set('dailyco.domain', 'test.daily.co');
    }
}
