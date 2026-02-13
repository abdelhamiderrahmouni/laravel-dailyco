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

This package is an unofficial SDK for [Daily.co](https://daily.co)'s REST API.

## Installation

1. Install with Composer `composer require abdelhamiderrahmouni/laravel-dailyco`
2. Specify your API key and domain in your `.env`
```
DAILYCO_API_KEY=
DAILYCO_DOMAIN=
```
3. You should now be able to perform API requests using the SDK!
4. [Optional] Publish configuration file with `php artisan vendor:publish --provider="AbdelhamidErrahmouni\LaravelDailyco\DailycoServiceProvider" --tag="config"`

## Usage

To make API requests, you can either use the Facade, or you could just manually use the `AbdelhamidErrahmouni\LaravelDailyco\Dailyco` class and call the methods from there.
We recommande using the Facade.

All of our below examples use the Facade.

### Rooms

**Get all rooms**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$rooms = DailycoFacade::rooms();
```

**Create a room**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$room = DailycoFacade::createRoom([...]);
```

**Get a room**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$room = DailycoFacade::room('roomId', [...]);
```

**Update a room**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$room = DailycoFacade::updateRoom('roomId', [...]);
```

**Delete a room**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

DailycoFacade::deleteRoom('roomId', [...]);
```

### Meeting tokens

**Create meeting token**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$token = DailycoFacade::createMeetingToken([...]);
```

**Get meeting token**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$token = DailycoFacade::meetingToken('meetingToken', [...]);
```

### Recordings

**Get recordings**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$recordings = DailycoFacade::recordings([...]);
```

**Get a recording**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$recording = DailycoFacade::recording('recordingId', [...]);
```

**Delete a recording**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$recording = DailycoFacade::deleteRecording('recordingId', [...]);
```

**Get recording access link**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$accessLink = DailycoFacade::recordingAccessLink('recordingId', [...]);
```

**Get recording download link**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$downloadLink = DailycoFacade::recordingDownload('recordingId', [...]);
```

**Create recording composite recipe**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$recipe = DailycoFacade::createRecordingCompositesRecipe('recordingId', [...]);
```

**Get recording composites**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$composites = DailycoFacade::recordingComposites('recordingId', [...]);
```

### Logs

**Get logs**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$logs = DailycoFacade::logs();
```

***Get API logs**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$apiLogs = DailycoFacade::apiLogs();
```

### Meeting Analytics

**Retrieve meeting analytics**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$analytics = DailycoFacade::meetings();
```

### Presence

**Active participants**
```php
use AbdelhamidErrahmouni\LaravelDailyco\DailycoFacade;

$participants = DailycoFacade::presence();
```

### Handling errors

This package will throw an exception whenever a non 200 response is returned from Daily.co's API. 
The full list of exceptions is provided below.

| **Status Code**         | **Exception**                                                              |
|-------------------------|----------------------------------------------------------------------------|
| 400 (Bad Request)       | `AbdelhamidErrahmouni\LaravelDailyco\Exceptions\BadRequestException`       |
| 401 (Unauthorized)      | `AbdelhamidErrahmouni\LaravelDailyco\Exceptions\UnauthorizedException`     |
| 403 (Forbidden)         | `AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ForbiddenException`        |
| 404 (Not Found)         | `AbdelhamidErrahmouni\LaravelDailyco\Exceptions\NotFoundException`         |
| 429 (Too Many Requests) | `AbdelhamidErrahmouni\LaravelDailyco\Exceptions\TooManyRequestsException`  |
| 5xx (Server Errors)     | `AbdelhamidErrahmouni\LaravelDailyco\Exceptions\ServerErrorException`      |

## Credits
- [Abdelhamid Errahmouni](https://github.com/abdelhamiderrahmouni)
- [All Contributors](https://github.com/abdelhamiderrahmouni/laravel-dailyco/contributors)

Special thanks to [Steadfast Collective](https://github.com/steadfast-collective) for their original package upon which we built this one.

## Security

If you find any security vulnerabilities in this package, please directly email [abdelhamiderrahmouni@gmail.com](mailto:abdelhamiderrahmouni@gmail.com), rather than using the issue tracker.
