<?php

return [

    'discord' => [
        'webhook_url' => env('DISCORD_WEBHOOK_URL'),
    ],
    'stats' => [
        'log_file'           => env('HTTP_SERVER_LOG_FILE'),
        'output_public_file' => 'stats.html',
    ],
    'hotlaps' => [
        'directory' => env('HOTLAPS_DIRECTORY'),
    ],
];
