<?php

namespace App\Actions;

class ConvertLaptime
{
    /**
     * Convert laptime.
     */
    public static function execute(int $ms): string
    {
        // Calculate minutes, seconds, and remaining milliseconds
        $minutes      = floor($ms / 60000);
        $seconds      = floor(($ms % 60000) / 1000);
        $milliseconds = $ms % 1000;

        // Format each component to ensure proper zero-padding
        $minutesFormatted      = str_pad($minutes, 2, '0', STR_PAD_LEFT);
        $secondsFormatted      = str_pad($seconds, 2, '0', STR_PAD_LEFT);
        $millisecondsFormatted = str_pad($milliseconds, 3, '0', STR_PAD_LEFT);

        // Combine the formatted components
        return "{$minutesFormatted}:{$secondsFormatted}.{$millisecondsFormatted}";
    }
}
