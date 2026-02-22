<?php

use AbdelhamidErrahmouni\LaravelDailyco\Dailyco;
use AbdelhamidErrahmouni\LaravelDailyco\DataObjects\LogResponseDTO;
use AbdelhamidErrahmouni\LaravelDailyco\DataObjects\PresenceDTO;
use AbdelhamidErrahmouni\LaravelDailyco\DataObjects\RoomDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::preventStrayRequests();
});

afterEach(function () {
    Http::allowStrayRequests();
});

describe('DTO Transformation', function () {
    it('returns RoomDTO for single room request', function () {
        $roomData = [
            'id' => '123',
            'name' => 'test-room',
            'api_created' => true,
            'privacy' => 'public',
            'url' => 'https://daily.co/test-room',
            'created_at' => '2023-10-01T12:00:00Z',
            'config' => [],
        ];

        Http::fake(['api.daily.co/*' => Http::response($roomData, 200)]);

        $dailyco = new Dailyco('test-key');
        $room = $dailyco->withDto()->room('test-room');

        expect($room)->toBeInstanceOf(RoomDTO::class)
            ->and($room->id)->toBe('123')
            ->and($room->name)->toBe('test-room')
            ->and($room->createdAt)->toBeInstanceOf(DateTimeImmutable::class);
    });

    it('returns Collection of RoomDTOs for rooms list request', function () {
        $roomsData = [
            'data' => [
                [
                    'id' => '123',
                    'name' => 'test-room-1',
                    'api_created' => true,
                    'privacy' => 'public',
                    'url' => 'https://daily.co/test-room-1',
                    'created_at' => '2023-10-01T12:00:00Z',
                    'config' => [],
                ],
                [
                    'id' => '456',
                    'name' => 'test-room-2',
                    'api_created' => false,
                    'privacy' => 'private',
                    'url' => 'https://daily.co/test-room-2',
                    'created_at' => '2023-10-02T12:00:00Z',
                    'config' => [],
                ],
            ],
        ];

        Http::fake(['api.daily.co/*' => Http::response($roomsData, 200)]);

        $dailyco = new Dailyco('test-key');
        $rooms = $dailyco->withDto()->rooms();

        expect($rooms)->toBeInstanceOf(Collection::class)
            ->and($rooms)->toHaveCount(2)
            ->and($rooms->first())->toBeInstanceOf(RoomDTO::class)
            ->and($rooms->first()->id)->toBe('123');
    });

    it('returns Collection of PresenceDTOs for roomPresence request with injection', function () {
        $presenceData = [
            'test-room' => [
                [
                    'id' => 'p1',
                    'userId' => 'u1',
                    'userName' => 'User 1',
                    'joinTime' => '2023-10-01T12:00:00Z',
                    'duration' => 100,
                ],
            ],
            'other-room' => [ // Should also work if API returned multiple rooms (unlikely for roomPresence but good for robustness)
                [
                    'id' => 'p2',
                    'userId' => 'u2',
                    'userName' => 'User 2',
                    'joinTime' => '2023-10-01T12:00:00Z',
                    'duration' => 200,
                ],
            ],
        ];

        Http::fake(['api.daily.co/*' => Http::response($presenceData, 200)]);

        $dailyco = new Dailyco('test-key');
        $presence = $dailyco->withDto()->roomPresence('test-room');

        expect($presence)->toBeInstanceOf(Collection::class)
            ->and($presence)->toHaveCount(2)
            ->and($presence->first())->toBeInstanceOf(PresenceDTO::class)
            ->and($presence->first()->room)->toBe('test-room')
            ->and($presence->last()->room)->toBe('other-room');
    });

    it('returns LogResponseDTO for logs request', function () {
        $logsData = [
            'logs' => [
                [
                    'time' => 1696161600,
                    'msg' => 'test message',
                    'level' => 'info',
                ],
            ],
            'metrics' => [],
        ];

        Http::fake(['api.daily.co/*' => Http::response($logsData, 200)]);

        $dailyco = new Dailyco('test-key');
        $logs = $dailyco->withDto()->logs();

        expect($logs)->toBeInstanceOf(LogResponseDTO::class)
            ->and($logs->logs)->toBeInstanceOf(Collection::class)
            ->and($logs->logs->first()->message)->toBe('test message');
    });

    it('returns original array for unmapped methods', function () {
        // createRoom is mapped, but let's assume we call something unmapped or if deleteRoom returns array
        // deleteRoom is mapped in my code but with no DTO config, so it returns result
        // Wait, deleteRoom is in dtoMap but commented out in my thought, let's check code.
        // Code has: // 'deleteRoom' returns status, keep as array
        // So it is NOT in the map (commented out key).

        Http::fake(['api.daily.co/*' => Http::response(['deleted' => true], 200)]);

        $dailyco = new Dailyco('test-key');
        $result = $dailyco->withDto()->deleteRoom('test-room');

        expect($result)->toBe(['deleted' => true]);
    });
});
