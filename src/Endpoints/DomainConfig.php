<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Endpoints;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ForbiddenException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;

trait DomainConfig
{
    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function getDomainConfig(array $data = [])
    {
        return $this->get('', $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function updateDomainConfig(array $data = [])
    {
        return $this->post('', $data);
    }
}
