<?php

use AbdelhamidErrahmouni\LaravelDailyco\Dailyco;
use AbdelhamidErrahmouni\LaravelDailyco\DataObjects\ApiLogDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::preventStrayRequests();
});

afterEach(function () {
    Http::allowStrayRequests();
});

describe('API Logs DTO', function () {
    it('returns Collection of ApiLogDTOs for apiLogs request', function () {
        $apiLogsData = [
            [
                'id' => '78f6b55c-e1a3-43fe-96eb-7e2a1698ab84',
                'userId' => '4f8a96b6-fb01-46b5-8431-97d9b3caad6d',
                'domainId' => '09ab4f7c-bd55-481e-aebc-7c794cf7b6dc',
                'source' => 'api',
                'ip' => '23.118.90.188',
                'method' => 'GET',
                'url' => '/api/v1/logs/api',
                'status' => 200,
                'createdAt' => '2023-09-07T19:19:58.000Z',
                'request' => null,
                'response' => null,
            ],
            [
                'id' => '741294ef-af95-4fcf-888c-b9bc1101d36b',
                'userId' => '4f8a96b6-fb01-46b5-8431-97d9b3caad6d',
                'domainId' => '09ab4f7c-bd55-481e-aebc-7c794cf7b6dc',
                'source' => 'api',
                'ip' => '23.118.90.188',
                'method' => 'GET',
                'url' => '/api/v1/logs/api?limit=2&starting_after=0c632199-be56-435a-add1-9c7af1dc59f9',
                'status' => 200,
                'createdAt' => '2023-09-07T19:19:23.000Z',
                'request' => null,
                'response' => null,
            ],
        ];

        Http::fake(['api.daily.co/*' => Http::response($apiLogsData, 200)]);

        $dailyco = new Dailyco('test-key');
        $logs = $dailyco->withDto()->apiLogs();

        expect($logs)->toBeInstanceOf(Collection::class)
            ->and($logs)->toHaveCount(2)
            ->and($logs->first())->toBeInstanceOf(ApiLogDTO::class)
            ->and($logs->first()->id)->toBe('78f6b55c-e1a3-43fe-96eb-7e2a1698ab84')
            ->and($logs->first()->status)->toBe(200);
    });
});
