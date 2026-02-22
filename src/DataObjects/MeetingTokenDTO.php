<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\DataObjects;

use AbdelhamidErrahmouni\LaravelDailyco\Contracts\DailycoDataObject;

class MeetingTokenDTO implements DailycoDataObject
{
    public function __construct(
        public string $token
    ) {}

    /**
     * Create a DTO from API response array.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        // Handle case where token might be the string itself or in an array
        // But the prompt says "from API response array"
        // createMeetingToken returns { "token": "..." }
        return new self(
            token: $data['token'] ?? ''
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
            'token' => $this->token,
        ];
    }
}
