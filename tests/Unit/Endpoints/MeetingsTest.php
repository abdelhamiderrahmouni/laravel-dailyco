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

it('gets meetings', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->meetings();

    Http::assertSent(fn ($request) => $request->method() === 'GET' && str_contains($request->url(), 'api.daily.co/v1/meetings'));
});

it('gets meetings with query parameters', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->meetings(['room' => 'my-room', 'from' => '2024-01-01']);

    Http::assertSent(fn ($request) => $request->data() === ['room' => 'my-room', 'from' => '2024-01-01']);
});

it('gets a specific meeting', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->meeting('meeting-123');

    Http::assertSent(fn ($request) => $request->method() === 'GET' && str_contains($request->url(), 'api.daily.co/v1/meetings/meeting-123'));
});

it('urlencodes meeting id when getting a meeting', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->meeting('meeting 123');

    Http::assertSent(fn ($request) => str_contains($request->url(), 'meeting%20123'));
});

it('gets meeting participants', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->meetingParticipants('meeting-123');

    Http::assertSent(fn ($request) => $request->method() === 'GET' && str_contains($request->url(), 'api.daily.co/v1/meetings/meeting-123/participants'));
});

it('urlencodes meeting id when getting participants', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->meetingParticipants('meeting#123');

    Http::assertSent(fn ($request) => str_contains($request->url(), 'meeting%23123'));
});
