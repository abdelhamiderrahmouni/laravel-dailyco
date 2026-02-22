<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Endpoints;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ForbiddenException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;

trait PhoneNumbers
{
    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function listAvailableNumbers(array $data = [])
    {
        return $this->get('list-available-numbers', $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function buyPhoneNumber(array $data = [])
    {
        return $this->post('buy-phone-number', $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function releasePhoneNumber(string $phoneNumberId, array $data = [])
    {
        $phoneNumberId = rawurlencode($phoneNumberId);

        return $this->delete("release-phone-number/{$phoneNumberId}", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function purchasedPhoneNumbers(array $data = [])
    {
        return $this->get('purchased-phone-numbers', $data);
    }
}
