<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\DataObjects;

use AbdelhamidErrahmouni\LaravelDailyco\Contracts\DailycoDataObject;

class RecordingDTO implements DailycoDataObject
{
    /**
     * @param  array<mixed>  $tracks
     */
    public function __construct(
        public string $id,
        public string $roomName,
        public int $startTs,
        public string $status,
        public int $maxParticipants,
        public int $duration,
        public ?string $s3Key, // Make nullable as it might not be present
        public ?string $mtgSessionId,
        public array $tracks = []
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
            roomName: $data['room_name'],
            startTs: $data['start_ts'],
            status: $data['status'],
            maxParticipants: $data['max_participants'] ?? 0,
            duration: $data['duration'] ?? 0,
            s3Key: $data['s3_key'] ?? null,
            mtgSessionId: $data['mtg_session_id'] ?? null,
            tracks: $data['tracks'] ?? []
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
            'room_name' => $this->roomName,
            'start_ts' => $this->startTs,
            'status' => $this->status,
            'max_participants' => $this->maxParticipants,
            'duration' => $this->duration,
            's3_key' => $this->s3Key,
            'mtg_session_id' => $this->mtgSessionId,
            'tracks' => $this->tracks,
        ];
    }
}
