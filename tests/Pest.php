<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(AbdelhamidErrahmouni\LaravelDailyco\Tests\TestCase::class)
    ->in('Unit', 'Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every test file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Create a mock response for Daily.co API.
 */
function mockDailyResponse(array $body, int $status = 200): void
{
    \Illuminate\Support\Facades\Http::fake([
        'api.daily.co/*' => \Illuminate\Support\Facades\Http::response($body, $status),
    ]);
}

/**
 * Assert that a request was sent to Daily.co API.
 */
function assertDailyRequest(string $method, string $endpoint): void
{
    \Illuminate\Support\Facades\Http::assertSent(function ($request) use ($method, $endpoint) {
        return $request->method() === strtoupper($method)
            && str_contains($request->url(), $endpoint);
    });
}
