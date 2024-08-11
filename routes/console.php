<?php

use App\Console\Commands\NotifyRaceRegistrations;
use App\Console\Commands\UpdateDrivers;
use App\Console\Commands\UpdateHotlaps;
use App\Console\Commands\UpdateRegistrations;
use Illuminate\Support\Facades\Schedule;

// Reuse the denseBeforeRaceStarts function to set proper launch times for the commands 
$denseBeforeRaceStarts = function () {
    $currentMinute = now()->minute;
    $generalRepetition = $currentMinute % 5 === 0;
    $denseZone = ($currentMinute >= 55 || $currentMinute <= 5);
    return $generalRepetition || $denseZone;
};

Schedule::command(UpdateDrivers::class)->everyFiveMinutes();
Schedule::command(UpdateHotlaps::class)->everyMinute();
Schedule::command(UpdateRegistrations::class)
    ->everyMinute()
    ->when($denseBeforeRaceStarts);
Schedule::command(NotifyRaceRegistrations::class)
    ->everyMinute()
    ->when($denseBeforeRaceStarts);
