<?php

use AbdelhamidErrahmouni\LaravelDailyco\Dailyco;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::preventStrayRequests();
});

afterEach(function () {
    Http::allowStrayRequests();
});

describe('Exception Throwing', function () {
    it('throws BadRequestException on 400 status', function () {
        Http::fake(['api.daily.co/*' => Http::response(['error' => 'Bad Request'], 400)]);

        $dailyco = new Dailyco('test-key');

        expect(fn () => $dailyco->rooms())
            ->toThrow(BadRequestException::class, 'Daily API: Bad Request');
    });

    it('throws UnauthorizedException on 401 status', function () {
        Http::fake(['api.daily.co/*' => Http::response(['error' => 'Unauthorized'], 401)]);

        $dailyco = new Dailyco('test-key');

        expect(fn () => $dailyco->rooms())
            ->toThrow(UnauthorizedException::class, 'Daily API: Unauthorized');
    });

    it('throws NotFoundException on 404 status', function () {
        Http::fake(['api.daily.co/*' => Http::response(['error' => 'Not Found'], 404)]);

        $dailyco = new Dailyco('test-key');

        expect(fn () => $dailyco->room('non-existent-room'))
            ->toThrow(NotFoundException::class, 'Daily API: 404 Not Found');
    });

    it('throws TooManyRequestsException on 429 status', function () {
        Http::fake(['api.daily.co/*' => Http::response(['error' => 'Too Many Requests'], 429)]);

        $dailyco = new Dailyco('test-key');

        expect(fn () => $dailyco->rooms())
            ->toThrow(TooManyRequestsException::class, 'Daily API: Too Many Requests');
    });

    it('throws ServerErrorException on 500 status', function () {
        Http::fake(['api.daily.co/*' => Http::response(['error' => 'Internal Server Error'], 500)]);

        $dailyco = new Dailyco('test-key');

        expect(fn () => $dailyco->rooms())
            ->toThrow(ServerErrorException::class, 'Daily API: Server Error');
    });

    it('throws ServerErrorException on 502 status', function () {
        Http::fake(['api.daily.co/*' => Http::response(['error' => 'Bad Gateway'], 502)]);

        $dailyco = new Dailyco('test-key');

        expect(fn () => $dailyco->rooms())
            ->toThrow(ServerErrorException::class, 'Daily API: Server Error');
    });

    it('throws ServerErrorException on 503 status', function () {
        Http::fake(['api.daily.co/*' => Http::response(['error' => 'Service Unavailable'], 503)]);

        $dailyco = new Dailyco('test-key');

        expect(fn () => $dailyco->rooms())
            ->toThrow(ServerErrorException::class, 'Daily API: Server Error');
    });

    it('includes endpoint url in exception message', function () {
        Http::fake(['api.daily.co/*' => Http::response(['error' => 'Not Found'], 404)]);

        $dailyco = new Dailyco('test-key');

        try {
            $dailyco->room('test-room');
        } catch (NotFoundException $e) {
            expect($e->getMessage())->toContain('api.daily.co/v1/rooms/test-room');
        }
    });
});

describe('Exception Inheritance', function () {
    it('all exceptions extend base Exception', function () {
        expect(new BadRequestException('test'))->toBeInstanceOf(Exception::class)
            ->and(new UnauthorizedException('test'))->toBeInstanceOf(Exception::class)
            ->and(new NotFoundException('test'))->toBeInstanceOf(Exception::class)
            ->and(new TooManyRequestsException('test'))->toBeInstanceOf(Exception::class)
            ->and(new ServerErrorException('test'))->toBeInstanceOf(Exception::class);
    });
});
