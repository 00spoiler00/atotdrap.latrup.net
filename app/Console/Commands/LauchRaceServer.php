<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class LauchRaceServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:launch-race-server';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launches the server and stores the logs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cmd = 'wine ' . storage_path('app/acc_server') . '/accServer.exe';

        $result = Process::timeout(10)->run($cmd);

        file_put_contents(storage_path('logs/acc-server.log'), $result->output());
    }
}
