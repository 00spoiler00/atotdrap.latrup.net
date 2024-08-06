<?php

use App\Console\Commands\UpdateDrivers;
use App\Console\Commands\UpdateRegistrations;
use App\Console\Commands\NotifyRaceRegistrations;
use App\Console\Commands\UpdateHotlaps;
use Illuminate\Support\Facades\Schedule;

Schedule::command(UpdateDrivers::class)->everyFiveMinutes();
Schedule::command(UpdateRegistrations::class)->everyFiveMinutes();
Schedule::command(NotifyRaceRegistrations::class)->everyFiveMinutes();
Schedule::command(UpdateHotlaps::class)->everyMinute();