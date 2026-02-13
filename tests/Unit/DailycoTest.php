<?php

use AbdelhamidErrahmouni\LaravelDailyco\Dailyco;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::preventStrayRequests();
});

afterEach(function () {
    Http::allowStrayRequests();
});

describe('HTTP Methods', function () {
    it('sends GET request with correct method', function () {
        Http::fake(['api.daily.co/*' => Http::response(['data' => 'test'], 200)]);

        $dailyco = new Dailyco('test-key');
        $dailyco->rooms();

        Http::assertSent(function ($request) {
            return $request->method() === 'GET'
                && str_contains($request->url(), 'api.daily.co/v1/rooms');
        });
    });

    it('sends POST request with correct method', function () {
        Http::fake(['api.daily.co/*' => Http::response(['name' => 'new-room'], 200)]);

        $dailyco = new Dailyco('test-key');
        $dailyco->createRoom(['name' => 'new-room']);

        Http::assertSent(function ($request) {
            return $request->method() === 'POST'
                && str_contains($request->url(), 'api.daily.co/v1/rooms');
        });
    });

    it('sends PUT request with correct method', function () {
        Http::fake(['api.daily.co/*' => Http::response(['name' => 'updated-room'], 200)]);

        // Create a test class with a public put method
        $dailyco = new class('test-key') extends Dailyco
        {
            public function testPut(string $endpoint, array $data = []): mixed
            {
                return $this->put($endpoint, $data);
            }
        };

        $dailyco->testPut('test-endpoint', ['data' => 'value']);

        Http::assertSent(function ($request) {
            return $request->method() === 'PUT';
        });
    });

    it('sends PATCH request with correct method', function () {
        Http::fake(['api.daily.co/*' => Http::response(['name' => 'patched-room'], 200)]);

        $dailyco = new class('test-key') extends Dailyco
        {
            public function testPatch(string $endpoint, array $data = []): mixed
            {
                return $this->patch($endpoint, $data);
            }
        };

        $dailyco->testPatch('test-endpoint', ['data' => 'value']);

        Http::assertSent(function ($request) {
            return $request->method() === 'PATCH';
        });
    });

    it('sends DELETE request with correct method', function () {
        Http::fake(['api.daily.co/*' => Http::response([], 200)]);

        $dailyco = new Dailyco('test-key');
        $dailyco->deleteRoom('test-room');

        Http::assertSent(function ($request) {
            return $request->method() === 'DELETE'
                && str_contains($request->url(), 'api.daily.co/v1/rooms/test-room');
        });
    });
});

describe('API Key Handling', function () {
    it('accepts api key via constructor', function () {
        Http::fake(['api.daily.co/*' => Http::response(['data' => []], 200)]);

        $dailyco = new Dailyco('constructor-api-key');
        $dailyco->rooms();

        Http::assertSent(function ($request) {
            return $request->hasHeader('Authorization', 'Bearer constructor-api-key');
        });
    });

    it('falls back to config when no constructor key provided', function () {
        config(['dailyco.token' => 'config-api-key']);
        Http::fake(['api.daily.co/*' => Http::response(['data' => []], 200)]);

        $dailyco = new Dailyco;
        $dailyco->rooms();

        Http::assertSent(function ($request) {
            return $request->hasHeader('Authorization', 'Bearer config-api-key');
        });
    });

    it('prefers constructor key over config', function () {
        config(['dailyco.token' => 'config-api-key']);
        Http::fake(['api.daily.co/*' => Http::response(['data' => []], 200)]);

        $dailyco = new Dailyco('constructor-api-key');
        $dailyco->rooms();

        Http::assertSent(function ($request) {
            return $request->hasHeader('Authorization', 'Bearer constructor-api-key');
        });
    });

    it('sets authorization header correctly', function () {
        Http::fake(['api.daily.co/*' => Http::response(['data' => []], 200)]);

        $dailyco = new Dailyco('bearer-token');
        $dailyco->rooms();

        Http::assertSent(function ($request) {
            return $request->hasHeader('Authorization', 'Bearer bearer-token');
        });
    });
});

describe('Response Handling', function () {
    it('returns json decoded response on 200', function () {
        Http::fake(['api.daily.co/*' => Http::response(['rooms' => [['name' => 'test']]], 200)]);

        $dailyco = new Dailyco('test-key');
        $result = $dailyco->rooms();

        expect($result)->toBe(['rooms' => [['name' => 'test']]]);
    });

    it('passes query parameters for GET requests', function () {
        Http::fake(['api.daily.co/*' => Http::response([], 200)]);

        $dailyco = new Dailyco('test-key');
        $dailyco->rooms(['limit' => 10, 'starting_after' => 'abc123']);

        Http::assertSent(function ($request) {
            return $request->method() === 'GET'
                && $request->data() === ['limit' => 10, 'starting_after' => 'abc123'];
        });
    });

    it('passes body data for POST requests', function () {
        Http::fake(['api.daily.co/*' => Http::response(['name' => 'new-room'], 200)]);

        $dailyco = new Dailyco('test-key');
        $dailyco->createRoom(['name' => 'new-room', 'privacy' => 'public']);

        Http::assertSent(function ($request) {
            return $request->method() === 'POST'
                && $request->data() === ['name' => 'new-room', 'privacy' => 'public'];
        });
    });
});
