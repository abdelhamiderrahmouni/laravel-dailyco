# Laravel Daily.co SDK

<p align="center">
    <a href="https://packagist.org/packages/abdelhamiderrahmouni/laravel-dailyco">
        <img src="https://img.shields.io/packagist/dt/abdelhamiderrahmouni/laravel-dailyco" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/abdelhamiderrahmouni/laravel-dailyco">
        <img src="https://img.shields.io/packagist/v/abdelhamiderrahmouni/laravel-dailyco" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/abdelhamiderrahmouni/laravel-dailyco">
        <img src="https://img.shields.io/packagist/l/abdelhamiderrahmouni/laravel-dailyco" alt="License">
    </a>
</p>

An unofficial Laravel SDK for [Daily.co](https://daily.co)'s REST API. This package provides a clean, expressive interface for interacting with Daily.co video infrastructure from your Laravel application — including support for rooms, meetings, recordings, transcripts, presence, and more.

## Requirements

- PHP 8.1 or higher
- Laravel 10, 11, or 12

## Installation

Install via Composer:

```bash
composer require abdelhamiderrahmouni/laravel-dailyco
```

Add your API key to your `.env` file:

```env
DAILYCO_API_KEY=your-api-key-here
DAILYCO_DOMAIN=your-domain-here # Optional
```

Optionally publish the configuration file:

```bash
php artisan vendor:publish --provider="AbdelhamidErrahmouni\LaravelDailyco\ServiceProvider" --tag="config"
```

## Usage

All methods are available via the `Dailyco` facade. You can also inject or instantiate `AbdelhamidErrahmouni\LaravelDailyco\Dailyco` directly if needed.

```php
use AbdelhamidErrahmouni\LaravelDailyco\Facades\Dailyco;
```

> All methods return a raw array by default. To receive typed Data Transfer Objects instead, see the [DTO Support](#dto-support) section.

---

### Rooms

```php
// Get all rooms
Dailyco::rooms();

// Get all rooms with filters
Dailyco::rooms(['limit' => 10, 'starting_after' => 'room-name']);

// Get a specific room
Dailyco::room('room-name');

// Create a room
Dailyco::createRoom([
    'name'    => 'my-room',
    'privacy' => 'public',
]);

// Update a room
Dailyco::updateRoom('room-name', [
    'privacy' => 'private',
]);

// Delete a room
Dailyco::deleteRoom('room-name');

// Get active participants in a room
Dailyco::roomPresence('room-name');

// Send an app message to participants in a room
Dailyco::sendAppMessage('room-name', ['data' => 'hello']);

// Get room session data
Dailyco::roomSessionData('room-name');

// Set room session data
Dailyco::setRoomSessionData('room-name', ['expiryTime' => 3600]);

// Eject all participants from a room
Dailyco::ejectParticipant('room-name');

// Update participant permissions in a room
Dailyco::updateParticipantPermissions('room-name', ['permissions' => [...]]);
```

---

### Meeting Tokens

```php
// Create a meeting token
Dailyco::createMeetingToken([
    'properties' => [
        'room_name' => 'my-room',
        'is_owner'  => true,
        'exp'       => now()->addHour()->timestamp,
    ],
]);

// Validate a meeting token
Dailyco::meetingToken('your-token-string');
```

---

### Meetings

```php
// Get all meetings
Dailyco::meetings();

// Get all meetings with filters
Dailyco::meetings(['room' => 'room-name', 'limit' => 20]);

// Get a specific meeting
Dailyco::meeting('meeting-id');

// Get participants for a meeting
Dailyco::meetingParticipants('meeting-id');
```

---

### Recordings

```php
// Get all recordings
Dailyco::recordings();

// Get a specific recording
Dailyco::recording('recording-id');

// Delete a recording
Dailyco::deleteRecording('recording-id');

// Get a short-lived access link for a recording
Dailyco::recordingAccessLink('recording-id');

// Get a download link using a share token
Dailyco::recordingDownload('share-token');

// Create a recording composites recipe
Dailyco::createRecordingCompositesRecipe('recording-id', [...]);

// Get composites for a recording
Dailyco::recordingComposites('recording-id');
```

---

### Transcripts

```php
// Get all transcripts
Dailyco::transcripts();

// Get a specific transcript
Dailyco::transcript('transcript-id');

// Delete a transcript
Dailyco::deleteTranscript('transcript-id');

// Get a short-lived access link for a transcript
Dailyco::transcriptAccessLink('transcript-id');
```

---

### Presence

```php
// Get near-real-time participant presence data across all rooms
Dailyco::presence();
```

---

### Logs

```php
// Get call logs and metrics
Dailyco::logs();

// Get call logs with filters
Dailyco::logs(['mtgSessionId' => 'session-id']);

// Get REST API request logs
Dailyco::apiLogs();
```

---

### Webhooks

```php
// Get all webhooks
Dailyco::webhooks();

// Create a webhook
Dailyco::createWebhook([
    'url'         => 'https://example.com/webhook',
    'event_types' => ['meeting.started', 'meeting.ended'],
]);

// Get a specific webhook
Dailyco::webhook('webhook-id');

// Update a webhook
Dailyco::updateWebhook('webhook-id', ['url' => 'https://example.com/new-webhook']);

// Delete a webhook
Dailyco::deleteWebhook('webhook-id');
```

---

### Domain Configuration

```php
// Get domain configuration
Dailyco::getDomainConfig();

// Update domain configuration
Dailyco::updateDomainConfig(['hipaa' => true]);
```

---

### Dial-in Configuration

```php
// List all dial-in configurations
Dailyco::listDomainDialinConfigs();

// Create a dial-in configuration
Dailyco::createDomainDialinConfig([...]);

// Get a specific dial-in configuration
Dailyco::domainDialinConfig('config-id');

// Update a dial-in configuration
Dailyco::updateDomainDialinConfig('config-id', [...]);

// Delete a dial-in configuration
Dailyco::deleteDomainDialinConfig('config-id');

// Update pinless call config
Dailyco::pinlessCallUpdate([...]);
```

---

### Phone Numbers

```php
// List available phone numbers to purchase
Dailyco::listAvailableNumbers();

// Buy a phone number
Dailyco::buyPhoneNumber(['country' => 'US']);

// List purchased phone numbers
Dailyco::purchasedPhoneNumbers();

// Release a purchased phone number
Dailyco::releasePhoneNumber('phone-number-id');
```

---

### Batch Processing

```php
// Get all batch jobs
Dailyco::batchJobs();

// Submit a new batch job
Dailyco::submitBatchJob([...]);

// Get a specific batch job
Dailyco::batchJob('job-id');

// Delete a batch job
Dailyco::deleteBatchJob('job-id');

// Get the output of a batch job
Dailyco::batchJobOutput('job-id');
```

---

## DTO Support

By default, all methods return raw arrays. To receive fully-typed PHP objects instead, chain `withDto()` before your method call. This does not mutate the singleton — every call to `withDto()` returns a fresh proxy instance.

```php
use AbdelhamidErrahmouni\LaravelDailyco\Facades\Dailyco;
```

### Available DTOs

| Method | Return Type |
|---|---|
| `rooms()` | `Collection<RoomDTO>` |
| `room()` | `RoomDTO` |
| `createRoom()` | `RoomDTO` |
| `updateRoom()` | `RoomDTO` |
| `roomPresence()` | `Collection<PresenceDTO>` |
| `meetings()` | `Collection<MeetingDTO>` |
| `meeting()` | `MeetingDTO` |
| `createMeetingToken()` | `MeetingTokenDTO` |
| `meetingToken()` | `MeetingTokenDTO` |
| `recordings()` | `Collection<RecordingDTO>` |
| `recording()` | `RecordingDTO` |
| `transcripts()` | `Collection<TranscriptDTO>` |
| `transcript()` | `TranscriptDTO` |
| `logs()` | `LogResponseDTO` |
| `apiLogs()` | `Collection<ApiLogDTO>` |

Methods not listed in the table (e.g. `deleteRoom`, `deleteRecording`) return the raw array as usual.

### Examples

**Single resource:**

```php
$room = Dailyco::withDto()->room('my-room');

echo $room->name;                         // string
echo $room->privacy;                      // string
echo $room->createdAt->format('Y-m-d');   // DateTimeImmutable
```

**List of resources:**

```php
$rooms = Dailyco::withDto()->rooms(); // Collection<RoomDTO>

foreach ($rooms as $room) {
    echo "{$room->name} ({$room->privacy})";
}
```

**Meeting with participants:**

```php
$meeting = Dailyco::withDto()->meeting('meeting-id');

echo $meeting->room;
echo $meeting->startTime->format('H:i'); // DateTimeImmutable

foreach ($meeting->participants as $participant) {
    echo $participant->userName;
    echo $participant->duration; // seconds
}
```

**Call logs (structured response):**

```php
$response = Dailyco::withDto()->logs();

// $response->logs is a Collection<LogDTO>
foreach ($response->logs as $log) {
    echo "[{$log->level}] {$log->message}";
}

// $response->metrics is a raw array (complex nested structure)
$metrics = $response->metrics;
```

**API request logs (flat list):**

```php
$apiLogs = Dailyco::withDto()->apiLogs(); // Collection<ApiLogDTO>

foreach ($apiLogs as $log) {
    echo "{$log->method} {$log->url} → {$log->status}";
}
```

**Presence (flattened by room):**

```php
$participants = Dailyco::withDto()->roomPresence('my-room'); // Collection<PresenceDTO>

foreach ($participants as $participant) {
    echo "{$participant->userName} in {$participant->room}";
}
```

---

## Handling Errors

This package throws typed exceptions for all non-2xx responses.

| Status Code | Exception |
|---|---|
| 400 Bad Request | `Exceptions\BadRequestException` |
| 401 Unauthorized | `Exceptions\UnauthorizedException` |
| 403 Forbidden | `Exceptions\ForbiddenException` |
| 404 Not Found | `Exceptions\NotFoundException` |
| 429 Too Many Requests | `Exceptions\TooManyRequestsException` |
| 5xx Server Error | `Exceptions\ServerErrorException` |

All exceptions are under the `AbdelhamidErrahmouni\LaravelDailyco\Exceptions` namespace.

```php
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException;
use AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException;

try {
    $room = Dailyco::room('non-existent-room');
} catch (NotFoundException $e) {
    // Room does not exist
} catch (TooManyRequestsException $e) {
    // Back off and retry
}
```

---

## Credits

- [Abdelhamid Errahmouni](https://github.com/abdelhamiderrahmouni)
- [All Contributors](https://github.com/abdelhamiderrahmouni/laravel-dailyco/contributors)

Special thanks to [Steadfast Collective](https://github.com/steadfast-collective) for their original package upon which this SDK was built.

## Security

If you discover a security vulnerability, please email [abdelhamiderrahmouni@gmail.com](mailto:abdelhamiderrahmouni@gmail.com) directly rather than using the issue tracker.

## License

This package is open-sourced software licensed under the [MIT License](LICENSE.md).
