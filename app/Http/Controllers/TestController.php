<?php

namespace App\Http\Controllers;

use App\Actions\GetMetricEarners;

class TestController extends Controller
{
    public function __invoke()
    {
        return GetMetricEarners::execute('pitskill', 3);
    }
}
