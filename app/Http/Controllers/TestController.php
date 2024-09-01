<?php

namespace App\Http\Controllers;

use App\Actions\GetMetricEarners;
use App\Models\Metric;

class TestController extends Controller
{
    public function __invoke()
    {
        return Metric::where('type', 'elo')->where('driver_id', 13)->get();

        return GetMetricEarners::execute('pitskill', 3);
    }
}
