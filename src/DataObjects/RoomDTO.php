<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\DataObjects;

use AbdelhamidErrahmouni\LaravelDailyco\Contracts\DailycoDataObject;
use DateTimeImmutable;

class RoomDTO implements DailycoDataObject
{
    /**
     * @param  array<string, mixed>  $config
     */
    public function __construct(
        public string $id,
        public string $name,
        public bool $apiCreated,
        public string $privacy,
        public string $url,
        public DateTimeImmutable $createdAt,
        public array $config = []
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
            name: $data['name'],
            apiCreated: $data['api_created'],
            privacy: $data['privacy'],
            url: $data['url'],
            createdAt: new DateTimeImmutable($data['created_at']),
            config: $data['config'] ?? []
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
            'name' => $this->name,
            'api_created' => $this->apiCreated,
            'privacy' => $this->privacy,
            'url' => $this->url,
            'created_at' => $this->createdAt->format(DateTimeImmutable::ATOM),
            'config' => $this->config,
        ];
    }
}
