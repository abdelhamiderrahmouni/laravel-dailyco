<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Endpoints;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ForbiddenException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;

trait Rooms
{
    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function rooms(array $data = [])
    {
        return $this->get('rooms', $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function createRoom(array $data = [])
    {
        return $this->post('rooms', $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function room(string $roomName, array $data = [])
    {
        $roomName = rawurlencode($roomName);

        return $this->get("rooms/{$roomName}", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function updateRoom(string $roomName, array $data = [])
    {
        $roomName = rawurlencode($roomName);

        return $this->post("rooms/{$roomName}", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function deleteRoom(string $roomName, array $data = [])
    {
        $roomName = rawurlencode($roomName);

        return $this->delete("rooms/{$roomName}", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function roomPresence(string $roomName, array $data = [])
    {
        $roomName = rawurlencode($roomName);

        return $this->get("rooms/{$roomName}/presence", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function sendAppMessage(string $roomName, array $data = [])
    {
        $roomName = rawurlencode($roomName);

        return $this->post("rooms/{$roomName}/send-app-message", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function roomSessionData(string $roomName, array $data = [])
    {
        $roomName = rawurlencode($roomName);

        return $this->get("rooms/{$roomName}/get-session-data", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function setRoomSessionData(string $roomName, array $data = [])
    {
        $roomName = rawurlencode($roomName);

        return $this->post("rooms/{$roomName}/set-session-data", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function ejectParticipant(string $roomName, array $data = [])
    {
        $roomName = rawurlencode($roomName);

        return $this->post("rooms/{$roomName}/eject", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function updateParticipantPermissions(string $roomName, array $data = [])
    {
        $roomName = rawurlencode($roomName);

        return $this->post("rooms/{$roomName}/update-permissions", $data);
    }
}
