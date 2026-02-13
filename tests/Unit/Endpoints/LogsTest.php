<?php

use AbdelhamidErrahmouni\LaravelDailyco\Dailyco;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::preventStrayRequests();
    Http::fake(['api.daily.co/*' => Http::response(['data' => []], 200)]);
});

afterEach(function () {
    Http::allowStrayRequests();
});

it('gets logs', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->logs();

    Http::assertSent(fn ($request) => $request->method() === 'GET' && str_contains($request->url(), 'api.daily.co/v1/logs'));
});

it('gets logs with query parameters', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->logs(['room' => 'my-room', 'start_time' => '2024-01-01']);

    Http::assertSent(fn ($request) => $request->data() === ['room' => 'my-room', 'start_time' => '2024-01-01']);
});
