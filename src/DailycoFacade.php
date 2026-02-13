<?php

namespace AbdelhamidErrahmouni\LaravelDailyco;

use Illuminate\Support\Facades\Facade;

class DailycoFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Dailyco';
    }
}
