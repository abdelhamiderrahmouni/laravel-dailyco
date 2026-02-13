<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Endpoints;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;

trait Rooms
{
    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    public function rooms(array $data = [])
    {
        return $this->get('rooms', $data);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    public function createRoom(array $data = [])
    {
        return $this->post('rooms', $data);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    public function room(string $roomName, array $data = [])
    {
        $roomName = urlencode($roomName);

        return $this->get("rooms/{$roomName}", $data);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    public function updateRoom(string $roomName, array $data = [])
    {
        $roomName = urlencode($roomName);

        return $this->post("rooms/{$roomName}", $data);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    public function deleteRoom(string $roomName, array $data = [])
    {
        $roomName = urlencode($roomName);

        return $this->delete("rooms/{$roomName}", $data);
    }
}
