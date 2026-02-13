<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Endpoints;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ForbiddenException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;

trait Recordings
{
    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function recordings(array $data = [])
    {
        return $this->get('recordings', $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function recording(string $recordingId, array $data = [])
    {
        $recordingId = rawurlencode($recordingId);

        return $this->get("recordings/{$recordingId}", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function deleteRecording(string $recordingId, array $data = [])
    {
        $recordingId = rawurlencode($recordingId);

        return $this->delete("recordings/{$recordingId}", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function recordingAccessLink(string $recordingId, array $data = [])
    {
        $recordingId = rawurlencode($recordingId);

        return $this->get("recordings/{$recordingId}/access-link", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function recordingDownload(string $shareToken, array $data = [])
    {
        $shareToken = rawurlencode($shareToken);

        return $this->get("recordings/{$shareToken}/download", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function createRecordingCompositesRecipe(string $recordingId, array $data = [])
    {
        $recordingId = rawurlencode($recordingId);

        return $this->post("recordings/{$recordingId}/composites", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function recordingComposites(string $recordingId, array $data = [])
    {
        $recordingId = rawurlencode($recordingId);

        return $this->get("recordings/{$recordingId}/composites", $data);
    }
}
