<?php

namespace App\Console\Commands;

use App\Models\Race;
use App\Models\Driver;
use App\Notifications\RaceRegistration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class NotifyRaceRegistrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-race-registrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifies the Discord channel about the new Race Registrations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Notifiying Discord channel about new race registrations');

        // Get the races with unnotified enrollments
        $unnotifiedRaces = Race::query()
            ->whereHas('enrollments', fn($q) => $q->where('is_notified', false))
            ->get();
        ;

        // Notify the Discord channel
        $unnotifiedRaces->each(function($race){
            
            // Find all the drivers that are registered for
            $drivers = Driver::query()
                ->whereHas('enrollments', 
                    fn ($q) => $q->whereHas('race', 
                        fn($q) => $q->where('id', $race->id))
                    )
                ->get()
                ->map(fn ($driver) => $driver->shortReadableId)
            ;

            $sof = $race->enrollments->last()->sof;

            // Build the message
            $message = "**{$drivers->join(', ')}** ".($drivers->count() > 1 ? 'apuntats' : 'apuntat')." per [{$race->name}](<{$race->enrollLink}>) *@{$race->starts_at}* ({$sof} SoF, {$race->registers})";

            // Get the Discord webhook URL from config
            $webhookUrl = config('atotdrap.discord.webhook_url');

            // Send the message to Discord
            Http::post($webhookUrl, ['content' => $message]);
        });

        // Update the enrollments as notified
        $unnotifiedRaces->each(fn($race) => $race->enrollments->each(fn($enrollment) => $enrollment->update(['is_notified' => true])));
    }
}
