<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\DataObjects;

use DateTimeImmutable;

class MeetingParticipantDTO
{
    public function __construct(
        public ?string $userId,
        public ?string $userName,
        public string $participantId,
        public DateTimeImmutable $joinTime,
        public int $duration
    ) {}

    /**
     * Create a DTO from API response array.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            userId: $data['user_id'] ?? null,
            userName: $data['user_name'] ?? null,
            participantId: $data['participant_id'],
            joinTime: new DateTimeImmutable('@'.$data['join_time']),
            duration: $data['duration']
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
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'participant_id' => $this->participantId,
            'join_time' => $this->joinTime->getTimestamp(),
            'duration' => $this->duration,
        ];
    }
}
