<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\DataObjects;

use AbdelhamidErrahmouni\LaravelDailyco\Contracts\DailycoDataObject;

class TranscriptDTO implements DailycoDataObject
{
    /**
     * @param  array<string, mixed>  $outParams
     */
    public function __construct(
        public string $transcriptId,
        public string $domainId,
        public string $roomId,
        public string $mtgSessionId,
        public string $status,
        public bool $isVttAvailable,
        public int $duration,
        public array $outParams,
        public ?string $error = null
    ) {}

    /**
     * Create a DTO from API response array.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            transcriptId: $data['transcript_id'],
            domainId: $data['domain_id'],
            roomId: $data['room_id'],
            mtgSessionId: $data['mtg_session_id'],
            status: $data['status'],
            isVttAvailable: $data['is_vtt_available'] ?? false,
            duration: $data['duration'] ?? 0,
            outParams: $data['out_params'] ?? [],
            error: $data['error'] ?? null
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
            'transcript_id' => $this->transcriptId,
            'domain_id' => $this->domainId,
            'room_id' => $this->roomId,
            'mtg_session_id' => $this->mtgSessionId,
            'status' => $this->status,
            'is_vtt_available' => $this->isVttAvailable,
            'duration' => $this->duration,
            'out_params' => $this->outParams,
            'error' => $this->error,
        ];
    }
}
