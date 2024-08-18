<?php

use App\Console\Commands\NotifyRaceRegistrations;
use App\Console\Commands\UpdateDriversAndRegistrations;
use App\Console\Commands\UpdateHotlaps;
use Illuminate\Support\Facades\Schedule;

// Reuse the denseBeforeRaceStarts function to set proper launch times for the commands
$denseBeforeRaceStarts = function () {
    $currentMinute     = now()->minute;
    $generalRepetition = $currentMinute % 5 === 0;
    $denseZone         = ($currentMinute >= 55 || $currentMinute <= 5);

    return $generalRepetition || $denseZone;
};

Schedule::command(UpdateDriversAndRegistrations::class)->everyMinute()->when($denseBeforeRaceStarts);
Schedule::command(UpdateHotlaps::class)->everyMinute();
Schedule::command(NotifyRaceRegistrations::class)
    ->everyMinute()
    ->when($denseBeforeRaceStarts);
