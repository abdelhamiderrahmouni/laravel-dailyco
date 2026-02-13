<?php

namespace AbdelhamidErrahmouni\LaravelDailyco;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ForbiddenException;
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
        private readonly ?string $apiKey = null,
    ) {}

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     * @throws ForbiddenException
     */
    protected function get(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('GET', $endpoint, $data, $headers);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     * @throws ForbiddenException
     */
    protected function post(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('POST', $endpoint, $data, $headers);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     * @throws ForbiddenException
     */
    protected function put(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('PUT', $endpoint, $data, $headers);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     * @throws ForbiddenException
     */
    protected function patch(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('PATCH', $endpoint, $data, $headers);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     * @throws ForbiddenException
     */
    protected function delete(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('DELETE', $endpoint, $data, $headers);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     * @throws ForbiddenException
     */
    protected function request(string $method, string $endpoint, array $data = [], array $headers = [])
    {
        $endpoint = 'https://api.daily.co/v1/'.$endpoint;
        $apiKey = $this->apiKey ?? config('dailyco.token');

        $headers = array_merge($headers, [
            'Authorization' => 'Bearer '.$apiKey,
        ]);

        $response = Http::withHeaders($headers)->{$method}($endpoint, $data);

        return match ($response->status()) {
            200 => $response->json(),
            400 => throw new BadRequestException("Daily API: Bad Request - {$endpoint}"),
            401 => throw new UnauthorizedException("Daily API: Unauthorized - {$endpoint}"),
            403 => throw new ForbiddenException("Daily API: Forbidden - {$endpoint}"),
            404 => throw new NotFoundException("Daily API: 404 Not Found - {$endpoint}"),
            429 => throw new TooManyRequestsException("Daily API: Too Many Requests - {$endpoint}"),
            default => throw new ServerErrorException("Daily API: Server Error - {$endpoint}"),
        };
    }
}
