<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function __invoke(Request $request)
    {
        return [
            'name'             => 'The remote validation for name is invalid',
            'relatives.name.0' => 'The remote validation for relative name is invalid',
        ];
    }
}
