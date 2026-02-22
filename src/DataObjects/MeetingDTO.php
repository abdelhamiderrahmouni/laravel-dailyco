<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\DataObjects;

use AbdelhamidErrahmouni\LaravelDailyco\Contracts\DailycoDataObject;
use DateTimeImmutable;

class MeetingDTO implements DailycoDataObject
{
    /**
     * @param  array<int, MeetingParticipantDTO>  $participants
     */
    public function __construct(
        public string $id,
        public string $room,
        public DateTimeImmutable $startTime,
        public int $duration,
        public bool $ongoing,
        public int $maxParticipants,
        public array $participants = []
    ) {}

    /**
     * Create a DTO from API response array.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $participants = [];
        if (isset($data['participants']) && is_array($data['participants'])) {
            foreach ($data['participants'] as $participant) {
                $participants[] = MeetingParticipantDTO::fromArray($participant);
            }
        }

        return new self(
            id: $data['id'],
            room: $data['room'],
            startTime: new DateTimeImmutable('@'.$data['start_time']),
            duration: $data['duration'],
            ongoing: $data['ongoing'],
            maxParticipants: $data['max_participants'],
            participants: $participants
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
            'room' => $this->room,
            'start_time' => $this->startTime->getTimestamp(),
            'duration' => $this->duration,
            'ongoing' => $this->ongoing,
            'max_participants' => $this->maxParticipants,
            'participants' => array_map(fn (MeetingParticipantDTO $p) => $p->toArray(), $this->participants),
        ];
    }
}
