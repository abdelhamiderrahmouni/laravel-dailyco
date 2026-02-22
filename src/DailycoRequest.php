<?php

namespace AbdelhamidErrahmouni\LaravelDailyco;

use AbdelhamidErrahmouni\LaravelDailyco\DataObjects\ApiLogDTO;
use AbdelhamidErrahmouni\LaravelDailyco\DataObjects\LogResponseDTO;
use AbdelhamidErrahmouni\LaravelDailyco\DataObjects\MeetingDTO;
use AbdelhamidErrahmouni\LaravelDailyco\DataObjects\MeetingTokenDTO;
use AbdelhamidErrahmouni\LaravelDailyco\DataObjects\PresenceDTO;
use AbdelhamidErrahmouni\LaravelDailyco\DataObjects\RecordingDTO;
use AbdelhamidErrahmouni\LaravelDailyco\DataObjects\RoomDTO;
use AbdelhamidErrahmouni\LaravelDailyco\DataObjects\TranscriptDTO;
use Illuminate\Support\Collection;

class DailycoRequest
{
    protected array $dtoMap = [
        // Rooms
        'rooms' => ['dto' => RoomDTO::class, 'collection' => true, 'wrapper' => 'data'],
        'createRoom' => ['dto' => RoomDTO::class],
        'room' => ['dto' => RoomDTO::class],
        'updateRoom' => ['dto' => RoomDTO::class],
        // 'deleteRoom' returns status, keep as array

        // Presence
        'roomPresence' => ['dto' => PresenceDTO::class, 'collection' => true, 'custom_handler' => 'handlePresence'],

        // Meetings
        'meetings' => ['dto' => MeetingDTO::class, 'collection' => true, 'wrapper' => 'data'],
        'meeting' => ['dto' => MeetingDTO::class],

        // Meeting Tokens
        'createMeetingToken' => ['dto' => MeetingTokenDTO::class],
        'meetingToken' => ['dto' => MeetingTokenDTO::class], // Might fail if structure differs

        // Recordings
        'recordings' => ['dto' => RecordingDTO::class, 'collection' => true, 'wrapper' => 'data'],
        'createRecording' => ['dto' => RecordingDTO::class],
        'recording' => ['dto' => RecordingDTO::class],
        // 'deleteRecording'

        // Transcripts
        'transcripts' => ['dto' => TranscriptDTO::class, 'collection' => true, 'wrapper' => 'data'],
        'transcript' => ['dto' => TranscriptDTO::class],
        // 'deleteTranscript'

        // Logs
        'logs' => ['dto' => LogResponseDTO::class],
        'apiLogs' => ['dto' => ApiLogDTO::class, 'collection' => true],
    ];

    public function __construct(
        protected Dailyco $dailyco
    ) {}

    public function __call(string $method, array $arguments)
    {
        $result = $this->dailyco->{$method}(...$arguments);

        if (! isset($this->dtoMap[$method])) {
            return $result;
        }

        $config = $this->dtoMap[$method];

        if (isset($config['custom_handler'])) {
            return $this->{$config['custom_handler']}($result);
        }

        $dtoClass = $config['dto'];

        // Handle Collection
        if (isset($config['collection']) && $config['collection']) {
            $items = $result;

            // Unwrap if needed
            if (isset($config['wrapper']) && isset($result[$config['wrapper']])) {
                $items = $result[$config['wrapper']];
            }

            return collect($items)->map(function ($item) use ($dtoClass) {
                return $dtoClass::fromArray($item);
            });
        }

        // Handle Single DTO
        return $dtoClass::fromArray($result);
    }

    protected function handlePresence(array $result): Collection
    {
        // Result format: { "roomName": [ {participant}, ... ], ... }
        $collection = collect();

        foreach ($result as $roomName => $participants) {
            // Check if $participants is actually an array of participants
            // Sometimes API returns other metadata at top level?
            // Assuming the structure is strictly map of room -> participants

            if (! is_array($participants)) {
                continue;
            }

            foreach ($participants as $participant) {
                // Inject room name
                $participant['room'] = $roomName;
                $collection->push(PresenceDTO::fromArray($participant));
            }
        }

        return $collection;
    }
}
