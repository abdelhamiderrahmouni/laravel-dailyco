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

it('gets all recordings', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->recordings();

    Http::assertSent(fn ($request) => $request->method() === 'GET' && str_contains($request->url(), 'api.daily.co/v1/recordings'));
});

it('gets recordings with query parameters', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->recordings(['room' => 'my-room', 'limit' => 5]);

    Http::assertSent(fn ($request) => $request->data() === ['room' => 'my-room', 'limit' => 5]);
});

it('gets a specific recording', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->recording('rec-123');

    Http::assertSent(fn ($request) => $request->method() === 'GET' && str_contains($request->url(), 'api.daily.co/v1/recordings/rec-123'));
});

it('urlencodes recording id when getting a recording', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->recording('rec 123');

    Http::assertSent(fn ($request) => str_contains($request->url(), 'rec%20123'));
});

it('deletes a recording', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->deleteRecording('rec-123');

    Http::assertSent(fn ($request) => $request->method() === 'DELETE' && str_contains($request->url(), 'api.daily.co/v1/recordings/rec-123'));
});

it('urlencodes recording id when deleting a recording', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->deleteRecording('rec/123');

    Http::assertSent(fn ($request) => str_contains($request->url(), 'rec%2F123'));
});

it('gets recording access link', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->recordingAccessLink('rec-123');

    Http::assertSent(fn ($request) => $request->method() === 'GET' && str_contains($request->url(), 'api.daily.co/v1/recordings/rec-123/access-link'));
});

it('urlencodes recording id for access link', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->recordingAccessLink('rec#123');

    Http::assertSent(fn ($request) => str_contains($request->url(), 'rec%23123'));
});

it('gets recording download link', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->recordingDownload('share-token-123');

    Http::assertSent(fn ($request) => $request->method() === 'GET' && str_contains($request->url(), 'api.daily.co/v1/recordings/share-token-123/download'));
});

it('urlencodes share token for download link', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->recordingDownload('token with spaces');

    Http::assertSent(fn ($request) => str_contains($request->url(), 'token%20with%20spaces'));
});

it('creates recording composites recipe', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->createRecordingCompositesRecipe('rec-123', ['format' => 'mp4']);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), 'api.daily.co/v1/recordings/rec-123/composites')
        && $request->data() === ['format' => 'mp4']);
});

it('urlencodes recording id when creating composites recipe', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->createRecordingCompositesRecipe('rec#123', []);

    Http::assertSent(fn ($request) => str_contains($request->url(), 'rec%23123'));
});

it('gets recording composites', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->recordingComposites('rec-123');

    Http::assertSent(fn ($request) => $request->method() === 'GET' && str_contains($request->url(), 'api.daily.co/v1/recordings/rec-123/composites'));
});

it('urlencodes recording id when getting composites', function () {
    $dailyco = new Dailyco('test-key');
    $dailyco->recordingComposites('rec 123');

    Http::assertSent(fn ($request) => str_contains($request->url(), 'rec%20123'));
});
