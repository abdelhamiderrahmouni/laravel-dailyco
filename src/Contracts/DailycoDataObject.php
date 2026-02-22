<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\Contracts;

interface DailycoDataObject
{
    /**
     * Create a DTO from API response array.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self;

    /**
     * Convert DTO to array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
