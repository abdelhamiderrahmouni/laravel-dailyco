<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\DataObjects;

use AbdelhamidErrahmouni\LaravelDailyco\Contracts\DailycoDataObject;
use DateTimeImmutable;

class PresenceDTO implements DailycoDataObject
{
    public function __construct(
        public string $id,
        public ?string $userId,
        public ?string $userName,
        public DateTimeImmutable $joinTime,
        public int $duration,
        public string $room
    ) {}

    /**
     * Create a DTO from API response array.
     * Note: This expects a flattened participant array with 'room' injected.
     * Or we can handle the injection outside.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            userId: $data['userId'] ?? null,
            userName: $data['userName'] ?? null,
            joinTime: new DateTimeImmutable($data['joinTime']),
            duration: $data['duration'] ?? 0,
            room: $data['room'] // This must be injected before calling fromArray
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
            'userName' => $this->userName,
            'joinTime' => $this->joinTime->format(DateTimeImmutable::ATOM),
            'duration' => $this->duration,
            'room' => $this->room,
        ];
    }
}
