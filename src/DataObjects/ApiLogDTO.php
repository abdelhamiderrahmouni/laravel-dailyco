<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\DataObjects;

use AbdelhamidErrahmouni\LaravelDailyco\Contracts\DailycoDataObject;
use DateTimeImmutable;

class ApiLogDTO implements DailycoDataObject
{
    public function __construct(
        public string $id,
        public ?string $userId,
        public ?string $domainId,
        public ?string $source,
        public ?string $ip,
        public ?string $method,
        public ?string $url,
        public int $status,
        public DateTimeImmutable $createdAt,
        public mixed $request = null,
        public mixed $response = null
    ) {}

    /**
     * Create a DTO from API response array.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            userId: $data['userId'] ?? null,
            domainId: $data['domainId'] ?? null,
            source: $data['source'] ?? null,
            ip: $data['ip'] ?? null,
            method: $data['method'] ?? null,
            url: $data['url'] ?? null,
            status: $data['status'] ?? 0,
            createdAt: new DateTimeImmutable($data['createdAt']),
            request: $data['request'] ?? null,
            response: $data['response'] ?? null
        );
    }

    /**
     * Convert DTO to array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'domainId' => $this->domainId,
            'source' => $this->source,
            'ip' => $this->ip,
            'method' => $this->method,
            'url' => $this->url,
            'status' => $this->status,
            'createdAt' => $this->createdAt->format(DateTimeImmutable::ATOM),
            'request' => $this->request,
            'response' => $this->response,
        ];
    }
}
