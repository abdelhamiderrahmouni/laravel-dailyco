<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Endpoints;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ForbiddenException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;

trait Webhooks
{
    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function webhooks(array $data = [])
    {
        return $this->get('webhooks', $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function createWebhook(array $data = [])
    {
        return $this->post('webhooks', $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function webhook(string $webhookId, array $data = [])
    {
        $webhookId = rawurlencode($webhookId);

        return $this->get("webhooks/{$webhookId}", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function updateWebhook(string $webhookId, array $data = [])
    {
        $webhookId = rawurlencode($webhookId);

        return $this->post("webhooks/{$webhookId}", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function deleteWebhook(string $webhookId, array $data = [])
    {
        $webhookId = rawurlencode($webhookId);

        return $this->delete("webhooks/{$webhookId}", $data);
    }
}
