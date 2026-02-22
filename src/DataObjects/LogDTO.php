<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\DataObjects;

use AbdelhamidErrahmouni\LaravelDailyco\Contracts\DailycoDataObject;
use DateTimeImmutable;

class LogDTO implements DailycoDataObject
{
    public function __construct(
        public DateTimeImmutable $time,
        public ?DateTimeImmutable $clientTime,
        public string $message,
        public ?string $mtgSessionId,
        public ?string $userSessionId,
        public ?string $peerId,
        public ?string $domainName,
        public ?string $level, // level might be string "info", "error" etc
        public ?int $code // code might be null
    ) {}

    /**
     * Create a DTO from API response array.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        // Handle optional fields
        return new self(
            time: isset($data['time']) ? new DateTimeImmutable('@'.$data['time']) : new DateTimeImmutable,
            clientTime: isset($data['client_time']) ? new DateTimeImmutable('@'.$data['client_time']) : null,
            message: $data['msg'] ?? $data['message'] ?? '',
            mtgSessionId: $data['mtg_session_id'] ?? null,
            userSessionId: $data['user_session_id'] ?? null,
            peerId: $data['peer_id'] ?? null,
            domainName: $data['domain_name'] ?? null,
            level: $data['level'] ?? null,
            code: $data['code'] ?? null
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
            'time' => $this->time->getTimestamp(),
            'client_time' => $this->clientTime?->getTimestamp(),
            'message' => $this->message,
            'mtg_session_id' => $this->mtgSessionId,
            'user_session_id' => $this->userSessionId,
            'peer_id' => $this->peerId,
            'domain_name' => $this->domainName,
            'level' => $this->level,
            'code' => $this->code,
        ];
    }
}
