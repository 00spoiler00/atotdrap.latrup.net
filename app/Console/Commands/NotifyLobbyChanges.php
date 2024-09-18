<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class NotifyLobbyChanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-lobby-changes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifies the Discord channel about changes in the lobbies';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Request the API at https://acc-status.jonatan.net/api/v2/acc/status and get 'status' value
        $response = Http::get('https://acc-status.jonatan.net/api/v2/acc/status');
        $status   = $response->json()['status'];

        // Check if storage has a file 'status', and if not, create it with value 1 using Storage facade
        if (! Storage::exists('status')) {
            Storage::put('status', 1);
        }

        // Get the value of the file 'status' using Storage facade
        $oldStatus = Storage::get('status');

        // If the status is different, update the file 'status' with the new value and notify the Discord channel
        if ($status != $oldStatus) {
            Storage::put('status', $status);

            // Build the message
            $statusString = $status ? 'funcionant' : 'caigut';
            $message      = "Canvi d'estat del lobby d'**ACC**, ara està **{$statusString}!**";

            // Get the Discord webhook URL from config
            $webhookUrl = config('atotdrap.discord.webhook_url');

            // Send the message to Discord
            Http::post($webhookUrl, ['content' => $message]);
        }
    }
}
