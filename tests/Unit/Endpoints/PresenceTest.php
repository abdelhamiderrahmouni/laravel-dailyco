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

it('gets presence', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->presence();

    Http::assertSent(fn ($request) => $request->method() === 'GET' && str_contains($request->url(), 'api.daily.co/v1/presence'));
});

it('gets presence with query parameters', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->presence(['room' => 'my-room']);

    Http::assertSent(fn ($request) => $request->data() === ['room' => 'my-room']);
});
