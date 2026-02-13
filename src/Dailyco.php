<?php

namespace AbdelhamidErrahmouni\LaravelDailyco;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Http;

class Dailyco
{
    use Endpoints\Logs;
    use Endpoints\MeetingAnalytics;
    use Endpoints\MeetingTokens;
    use Endpoints\Presence;
    use Endpoints\Recordings;
    use Endpoints\Rooms;

    public function __construct(
        private readonly string|null $apiKey = null,
    )
    {}

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    protected function get(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('GET', $endpoint, $data, $headers);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    protected function post(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('POST', $endpoint, $data, $headers);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    protected function put(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('PUT', $endpoint, $data, $headers);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    protected function patch(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('PATCH', $endpoint, $data, $headers);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    protected function delete(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('DELETE', $endpoint, $data, $headers);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    protected function request(string $method, string $endpoint, array $data = [], array $headers = [])
    {
        $endpoint = 'https://api.daily.co/v1/' . $endpoint;
        $apiKey = $this->apiKey ?? config('dailyco.token');

        $headers = array_merge($headers, [
            'Authorization' => 'Bearer ' . $apiKey,
        ]);

        $response = Http::withHeaders($headers)->{$method}($endpoint, $data);

        if ($response->status() === 200) {
            return $response->json();
        }

        if ($response->status() === 404) {
            throw new Exceptions\NotFoundException("Daily API: 404 Not Found - {$endpoint}");
        }

        if ($response->status() === 400) {
            throw new Exceptions\BadRequestException("Daily API: Bad Request - {$endpoint}");
        }

        if ($response->status() === 401) {
            throw new Exceptions\UnauthorizedException("Daily API: Unauthorized - {$endpoint}");
        }

        if ($response->status() === 429) {
            throw new Exceptions\TooManyRequestsException("Daily API: Too Many Requests - {$endpoint}");
        }

        throw new Exceptions\ServerErrorException("Daily API: Server Error - {$endpoint}");
    }
}
