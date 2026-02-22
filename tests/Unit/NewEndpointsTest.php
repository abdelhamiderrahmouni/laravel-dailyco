<?php

use AbdelhamidErrahmouni\LaravelDailyco\Dailyco;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::preventStrayRequests();
});

afterEach(function () {
    Http::allowStrayRequests();
});

describe('New Endpoints', function () {
    test('transcripts endpoint sends GET request', function () {
        Http::fake(['api.daily.co/v1/transcript' => Http::response(['data' => []], 200)]);

        $dailyco = new Dailyco('test-key');
        $dailyco->transcripts();

        Http::assertSent(function ($request) {
            return $request->method() === 'GET'
                && $request->url() === 'https://api.daily.co/v1/transcript';
        });
    });

    test('webhooks endpoint sends GET request', function () {
        Http::fake(['api.daily.co/v1/webhooks' => Http::response(['data' => []], 200)]);

        $dailyco = new Dailyco('test-key');
        $dailyco->webhooks();

        Http::assertSent(function ($request) {
            return $request->method() === 'GET'
                && $request->url() === 'https://api.daily.co/v1/webhooks';
        });
    });

    test('domain config endpoint sends GET request', function () {
        Http::fake(['api.daily.co/v1/' => Http::response(['data' => []], 200)]);

        $dailyco = new Dailyco('test-key');
        $dailyco->getDomainConfig();

        Http::assertSent(function ($request) {
            return $request->method() === 'GET'
                && $request->url() === 'https://api.daily.co/v1/';
        });
    });

    test('batch processor endpoint sends POST request', function () {
        Http::fake(['api.daily.co/v1/batch-processor' => Http::response(['data' => []], 200)]);

        $dailyco = new Dailyco('test-key');
        $dailyco->submitBatchJob(['preset' => 'transcript']);

        Http::assertSent(function ($request) {
            return $request->method() === 'POST'
                && $request->url() === 'https://api.daily.co/v1/batch-processor'
                && $request['preset'] === 'transcript';
        });
    });

    test('phone numbers endpoint sends GET request', function () {
        Http::fake(['api.daily.co/v1/list-available-numbers' => Http::response(['data' => []], 200)]);

        $dailyco = new Dailyco('test-key');
        $dailyco->listAvailableNumbers();

        Http::assertSent(function ($request) {
            return $request->method() === 'GET'
                && $request->url() === 'https://api.daily.co/v1/list-available-numbers';
        });
    });

    test('dialin config endpoint sends POST request', function () {
        Http::fake(['api.daily.co/v1/domain-dialin-config' => Http::response(['data' => []], 200)]);

        $dailyco = new Dailyco('test-key');
        $dailyco->createDomainDialinConfig(['phone_number' => '+1234567890']);

        Http::assertSent(function ($request) {
            return $request->method() === 'POST'
                && $request->url() === 'https://api.daily.co/v1/domain-dialin-config'
                && $request['phone_number'] === '+1234567890';
        });
    });

    test('updated updateRoom uses POST', function () {
        Http::fake(['api.daily.co/v1/rooms/test-room' => Http::response(['data' => []], 200)]);

        $dailyco = new Dailyco('test-key');
        $dailyco->updateRoom('test-room', ['privacy' => 'private']);

        Http::assertSent(function ($request) {
            return $request->method() === 'POST'
                && $request->url() === 'https://api.daily.co/v1/rooms/test-room'
                && $request['privacy'] === 'private';
        });
    });

    test('roomPresence uses GET', function () {
        Http::fake(['api.daily.co/v1/rooms/test-room/presence' => Http::response(['data' => []], 200)]);

        $dailyco = new Dailyco('test-key');
        $dailyco->roomPresence('test-room');

        Http::assertSent(function ($request) {
            return $request->method() === 'GET'
                && $request->url() === 'https://api.daily.co/v1/rooms/test-room/presence';
        });
    });
});
