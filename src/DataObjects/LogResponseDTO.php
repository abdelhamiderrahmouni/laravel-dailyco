<?php

namespace AbdelhamidErrahmouni\LaravelDailyco\DataObjects;

use AbdelhamidErrahmouni\LaravelDailyco\Contracts\DailycoDataObject;
use Illuminate\Support\Collection;

class LogResponseDTO implements DailycoDataObject
{
    /**
     * @param  Collection<int, LogDTO>  $logs
     * @param  array<mixed>  $metrics
     */
    public function __construct(
        public Collection $logs,
        public array $metrics = []
    ) {}

    /**
     * Create a DTO from API response array.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $logs = collect([]);
        if (isset($data['logs']) && is_array($data['logs'])) {
            $logs = collect($data['logs'])->map(function ($log) {
                return LogDTO::fromArray($log);
            });
        }

        return new self(
            logs: $logs,
            metrics: $data['metrics'] ?? []
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
            'logs' => $this->logs->map(fn (LogDTO $log) => $log->toArray())->toArray(),
            'metrics' => $this->metrics,
        ];
    }
}
