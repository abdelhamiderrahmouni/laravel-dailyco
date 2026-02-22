<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Endpoints;

use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ForbiddenException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException;

trait BatchProcessor
{
    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function batchJobs(array $data = [])
    {
        return $this->get('batch-processor', $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function submitBatchJob(array $data = [])
    {
        return $this->post('batch-processor', $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function batchJob(string $jobId, array $data = [])
    {
        $jobId = rawurlencode($jobId);

        return $this->get("batch-processor/{$jobId}", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function deleteBatchJob(string $jobId, array $data = [])
    {
        $jobId = rawurlencode($jobId);

        return $this->delete("batch-processor/{$jobId}", $data);
    }

    /**
     * @throws TooManyRequestsException|BadRequestException|NotFoundException
     * @throws ForbiddenException|UnauthorizedException|ServerErrorException
     */
    public function batchJobOutput(string $jobId, array $data = [])
    {
        $jobId = rawurlencode($jobId);

        return $this->get("batch-processor/{$jobId}/access-link", $data);
    }
}
