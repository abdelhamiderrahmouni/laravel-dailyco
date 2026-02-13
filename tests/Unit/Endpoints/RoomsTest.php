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

it('gets all rooms', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->rooms();

    Http::assertSent(fn ($request) => $request->method() === 'GET' && str_contains($request->url(), 'api.daily.co/v1/rooms'));
});

it('gets rooms with query parameters', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->rooms(['limit' => 10, 'starting_after' => 'abc123']);

    Http::assertSent(fn ($request) => $request->data() === ['limit' => 10, 'starting_after' => 'abc123']);
});

it('creates a room', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->createRoom(['name' => 'my-room', 'privacy' => 'public']);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), 'api.daily.co/v1/rooms')
        && $request->data() === ['name' => 'my-room', 'privacy' => 'public']);
});

it('gets a specific room', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->room('test-room');

    Http::assertSent(fn ($request) => $request->method() === 'GET'
        && str_contains($request->url(), 'api.daily.co/v1/rooms/test-room'));
});

it('urlencodes room name when getting a room', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->room('room with spaces');

    Http::assertSent(fn ($request) => str_contains($request->url(), 'room%20with%20spaces'));
});

it('updates a room', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->updateRoom('test-room', ['privacy' => 'private']);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), 'api.daily.co/v1/rooms/test-room')
        && $request->data() === ['privacy' => 'private']);
});

it('urlencodes room name when updating a room', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->updateRoom('room#special', ['privacy' => 'private']);

    Http::assertSent(fn ($request) => str_contains($request->url(), 'room%23special'));
});

it('deletes a room', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->deleteRoom('test-room');

    Http::assertSent(fn ($request) => $request->method() === 'DELETE'
        && str_contains($request->url(), 'api.daily.co/v1/rooms/test-room'));
});

it('urlencodes room name when deleting a room', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->deleteRoom('room/test');

    Http::assertSent(fn ($request) => str_contains($request->url(), 'room%2Ftest'));
});
