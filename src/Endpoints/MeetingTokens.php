<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Endpoints;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ForbiddenException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;

trait MeetingTokens
{
    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     * @throws ForbiddenException
     */
    public function createMeetingToken(array $data = [])
    {
        return $this->post('meeting-tokens', $data);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     * @throws ForbiddenException
     */
    public function meetingToken(string $meetingToken, array $data = [])
    {
        $meetingToken = rawurlencode($meetingToken);

        return $this->get("meeting-tokens/{$meetingToken}", $data);
    }
}
