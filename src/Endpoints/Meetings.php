<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Endpoints;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ForbiddenException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;

trait Meetings
{
    /**
     * This endpoint `/meetings` returns a list of meeting sessions.
     * @see https://docs.daily.co/reference/rest-api/meetings/get-meeting-information
     * ---
     *
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function meetings(array $data = [])
    {
        return $this->get('meetings', $data);
    }

    /**
     * This endpoint `/meetings/{meeting}` returns information about a specific meeting session.
     * @see https://docs.daily.co/reference/rest-api/meetings/get-meetings-meeting
     * ---
     *
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function meeting(string $meetingId, array $data = [])
    {
        $meetingId = rawurlencode($meetingId);

        return $this->get("meetings/{$meetingId}", $data);
    }

    /**
     * This endpoint `/meetings/{meeting}/participants` returns a list of participants in a specific meeting session.
     * @see https://docs.daily.co/reference/rest-api/meetings/get-meeting-participants
     * ---
     *
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function meetingParticipants(string $meetingId, array $data = [])
    {
        $meetingId = rawurlencode($meetingId);

        return $this->get("meetings/{$meetingId}/participants", $data);
    }
}
