<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Endpoints;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ForbiddenException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;

/**
 * You can access call logs and metrics for every call to help you better understand your calls and troubleshoot issues as they arise.
 * @see https://docs.daily.co/reference/rest-api/logs
 */
trait Logs
{
    /**
     * This endpoint `/logs` returns a list of logs filtered by the provided query parameters.
     * @see https://docs.daily.co/reference/rest-api/logs/list-logs
     * ---
     *
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function logs(array $data = [])
    {
        return $this->get('logs', $data);
    }

    /**
     * This endpoint `/logs/api` returns a list of REST API logs.
     * @see https://docs.daily.co/reference/rest-api/logs/list-api-logs
     * ---
     *
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function apiLogs(array $data = [])
    {
        return $this->get('logs/api', $data);
    }
}
