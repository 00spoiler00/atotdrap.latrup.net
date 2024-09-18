<?php

use App\Console\Commands\NotifyLobbyChanges;
use App\Console\Commands\NotifyRaceRegistrations;
use App\Console\Commands\UpdateDriversAndRegistrations;
use App\Console\Commands\UpdateHotlaps;
use App\Console\Commands\UpdateStats;
use Illuminate\Support\Facades\Schedule;

// Reuse the denseBeforeRaceStarts function to set proper launch times for the commands
$denseBeforeRaceStarts = function () {
    $currentMinute     = now()->minute;
    $generalRepetition = $currentMinute % 5 === 0;
    $denseZone         = ($currentMinute >= 55 || $currentMinute <= 5);

    return $generalRepetition || $denseZone;
};

Schedule::command(UpdateHotlaps::class)->everyMinute();
// The active drivers are updated every minute (with a dense zone filtering)
Schedule::command(UpdateDriversAndRegistrations::class, ['--onlyActive'])->everyMinute()->when($denseBeforeRaceStarts);
// The non active drivers are updated every 30 minutes
Schedule::command(UpdateDriversAndRegistrations::class)->everyThirtyMinutes();
Schedule::command(NotifyRaceRegistrations::class)->everyMinute()->when($denseBeforeRaceStarts);
Schedule::command(NotifyLobbyChanges::class)->everyMinute();
Schedule::command(UpdateStats::class)->everyFiveMinutes();
