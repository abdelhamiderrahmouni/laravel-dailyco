<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Endpoints;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ForbiddenException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;

trait DialinConfig
{
    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function listDomainDialinConfigs(array $data = [])
    {
        return $this->get('domain-dialin-config', $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function createDomainDialinConfig(array $data = [])
    {
        return $this->post('domain-dialin-config', $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function domainDialinConfig(string $configId, array $data = [])
    {
        $configId = rawurlencode($configId);

        return $this->get("domain-dialin-config/{$configId}", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function updateDomainDialinConfig(string $configId, array $data = [])
    {
        $configId = rawurlencode($configId);

        return $this->post("domain-dialin-config/{$configId}", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function deleteDomainDialinConfig(string $configId, array $data = [])
    {
        $configId = rawurlencode($configId);

        return $this->delete("domain-dialin-config/{$configId}", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function pinlessCallUpdate(array $data = [])
    {
        return $this->post('dialin/pinlessCallUpdate', $data);
    }
}
