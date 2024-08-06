<?php

use App\Console\Commands\UpdateDrivers;
use App\Console\Commands\UpdateRegistrations;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command(UpdateDrivers::class)->everyFiveMinutes()->withoutOverlapping()->runInBackground();
Schedule::command(UpdateRegistrations::class)->everyFiveMinutes()->withoutOverlapping()->runInBackground();