<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class RaceRegistration extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(Race $notifiable): array
    {
        return ['discord'];
    }

    public function toDiscord(Race $notifiable): DiscordMessage
    {
        $webhookUrl = 'https://discord.com/api/webhooks/1266833272697262112/SgaD33o4eRmwmWRa0xG3fChIRgnK4_Y-Jz4hhml0jArIZSlGFOVlIRZfvAwkS5EvwxdG';
        
        // Find all the drivers that are registered for
        $drivers = Driver::whereHas('enrollments', fn ($q) => $q->where('id', $notifiable->id))->get()->join(', ', fn ($driver) => $driver->readableId);

        $message = "**{$drivers}** apuntats per [{$notifiable->name}](<https://pitskill.io/event/{$race->enrollLink}>) *@{$race->startsAt->format('d/m h:i')}* ({$race->sof} SoF, {$race->registered})";
        
        $response = Http::post($webhookUrl, ['content' => $message]);
        
        return $response->body();
    }
}
