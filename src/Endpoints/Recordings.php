<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Endpoints;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;

trait Recordings
{
    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    public function recordings(array $data = [])
    {
        return $this->get('recordings', $data);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    public function recording(string $recordingId, array $data = [])
    {
        $recordingId = urlencode($recordingId);

        return $this->get("recordings/{$recordingId}", $data);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    public function deleteRecording(string $recordingId, array $data = [])
    {
        $recordingId = urlencode($recordingId);

        return $this->delete("recordings/{$recordingId}", $data);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    public function recordingAccessLink(string $recordingId, array $data = [])
    {
        $recordingId = urlencode($recordingId);

        return $this->get("recordings/{$recordingId}/access-link", $data);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    public function recordingDownload(string $shareToken, array $data = [])
    {
        $shareToken = urlencode($shareToken);

        return $this->get("recordings/{$shareToken}/download", $data);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    public function createRecordingCompositesRecipe(string $recordingId, array $data = [])
    {
        $recordingId = urlencode($recordingId);

        return $this->post("recordings/{$recordingId}/composites", $data);
    }

    /**
     * @throws ServerErrorException|TooManyRequestsException|BadRequestException|NotFoundException|UnauthorizedException
     */
    public function recordingComposites(string $recordingId, array $data = [])
    {
        $recordingId = urlencode($recordingId);

        return $this->get("recordings/{$recordingId}/composites", $data);
    }
}
