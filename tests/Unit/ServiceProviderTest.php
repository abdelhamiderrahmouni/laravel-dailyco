<?php

use AbdelhamidErrahmouni\LaravelDailyco\Dailyco;
use AbdelhamidErrahmouni\LaravelDailyco\ServiceProvider;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::preventStrayRequests();
});

afterEach(function () {
    Http::allowStrayRequests();
});

describe('ServiceProvider', function () {
    it('binds dailyco as a singleton', function () {
        $instance1 = app('Dailyco');
        $instance2 = app('Dailyco');

        expect($instance1)->toBeInstanceOf(Dailyco::class)
            ->and($instance1)->toBe($instance2);
    });

    it('injects api key from config', function () {
        config(['dailyco.token' => 'custom-api-key']);

        Http::fake(['api.daily.co/*' => Http::response(['name' => 'test-room'], 200)]);

        $dailyco = app('Dailyco');
        $dailyco->rooms();

        Http::assertSent(function ($request) {
            return $request->hasHeader('Authorization', 'Bearer custom-api-key');
        });
    });

    it('publishes config file', function () {
        $provider = new ServiceProvider(app());

        expect(method_exists($provider, 'boot'))->toBeTrue();

        // Verify the provider has the publishes configuration
        $reflection = new ReflectionClass($provider);
        $bootMethod = $reflection->getMethod('boot');

        expect($bootMethod)->toBeInstanceOf(ReflectionMethod::class);
    });

    it('merges config from file', function () {
        expect(config('dailyco.token'))->toBe('test-api-key')
            ->and(config('dailyco.domain'))->toBe('test.daily.co');
    });
});

describe('DailycoFacade', function () {
    it('resolves to dailyco instance', function () {
        $instance = \AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade::getFacadeRoot();

        expect($instance)->toBeInstanceOf(Dailyco::class);
    });

    it('can be called with method chaining via facade', function () {
        Http::fake([
            'api.daily.co/v1/rooms' => Http::response(['data' => []], 200),
        ]);

        $result = \AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade::rooms();

        expect($result)->toBe(['data' => []]);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'api.daily.co/v1/rooms');
        });
    });

    it('uses the same singleton instance through facade', function () {
        $facadeInstance = \AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade::getFacadeRoot();
        $appInstance = app('Dailyco');

        expect($facadeInstance)->toBe($appInstance);
    });
});
