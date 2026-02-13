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

it('creates a meeting token', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->createMeetingToken(['room_name' => 'my-room', 'is_owner' => true]);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), 'api.daily.co/v1/meeting-tokens')
        && $request->data() === ['room_name' => 'my-room', 'is_owner' => true]);
});

it('gets a meeting token', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->meetingToken('token-123');

    Http::assertSent(fn ($request) => $request->method() === 'GET' && str_contains($request->url(), 'api.daily.co/v1/meeting-tokens/token-123'));
});

it('urlencodes meeting token when getting', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->meetingToken('token with spaces');

    Http::assertSent(fn ($request) => str_contains($request->url(), 'token%20with%20spaces'));
});
