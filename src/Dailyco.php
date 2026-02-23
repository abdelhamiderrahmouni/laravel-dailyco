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
    use Endpoints\BatchProcessor;
    use Endpoints\DialinConfig;
    use Endpoints\DomainConfig;
    use Endpoints\Logs;
    use Endpoints\Meetings;
    use Endpoints\MeetingTokens;
    use Endpoints\PhoneNumbers;
    use Endpoints\Presence;
    use Endpoints\Recordings;
    use Endpoints\Rooms;
    use Endpoints\Transcripts;
    use Endpoints\Webhooks;

    public function __construct(
        private readonly ?string $apiKey = null,
    ) {}

    /**
     * Return a new DailycoRequest instance that returns DTOs instead of arrays.
     */
    public function withDto(): DailycoRequest
    {
        return new DailycoRequest($this);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    protected function get(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('GET', $endpoint, $data, $headers);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    protected function post(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('POST', $endpoint, $data, $headers);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    protected function put(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('PUT', $endpoint, $data, $headers);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    protected function patch(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('PATCH', $endpoint, $data, $headers);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    protected function delete(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('DELETE', $endpoint, $data, $headers);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    protected function request(string $method, string $endpoint, array $data = [], array $headers = [])
    {
        $endpoint = 'https://api.daily.co/v1/'.$endpoint;
        $apiKey = $this->apiKey ?? config('dailyco.token');

        $headers = array_merge($headers, [
            'Authorization' => 'Bearer '.$apiKey,
            'Content-Type' => 'application/json',
        ]);

        $response = Http::withHeaders($headers)->{$method}($endpoint, $data);

        $status = $response->status();

        if ($status >= 200 && $status < 300) {
            return $response->json();
        }

        $errorMessage = $response->json('info') ?? $response->body();

        match ($status) {
            400 => throw new BadRequestException("Daily API: Bad Request - {$endpoint}. Info: {$errorMessage}"),
            401 => throw new UnauthorizedException("Daily API: Unauthorized - {$endpoint}. Info: {$errorMessage}"),
            403 => throw new ForbiddenException("Daily API: Forbidden - {$endpoint}. Info: {$errorMessage}"),
            404 => throw new NotFoundException("Daily API: 404 Not Found - {$endpoint}. Info: {$errorMessage}"),
            429 => throw new TooManyRequestsException("Daily API: Too Many Requests - {$endpoint}. Info: {$errorMessage}"),
            default => throw new ServerErrorException("Daily API: Server Error - {$endpoint}. Status: {$status}. Info: {$errorMessage}"),
        };
    }
}
