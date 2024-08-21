<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UpdateStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the stats of the site';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Set the log file path, reading it from config at atotdrap.stats.log_file
        $logFile = config('atotdrap.stats.log_file');

        // Set the output file path, reading it from config at atotdrap.stats.output_file
        $outputFile = Storage::disk('public')->path(config('atotdrap.stats.output_public_file'));

        // Build the shell command 'sudo goaccess $logfile --log-format=COMBINED -o $outputFile'
        $cmd = "sudo goaccess {$logFile} --log-format=COMBINED -o {$outputFile}";

        // Execute the shell command
        shell_exec($cmd);
    }
}
