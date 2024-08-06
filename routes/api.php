<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/track/{track}/hotlaps', 'App\Http\Controllers\TrackController@hotlaps');
Route::get('/driver/{driver}/hotlaps', 'App\Http\Controllers\DriverController@hotlaps');
Route::get('/driver/{driver}/metrics', 'App\Http\Controllers\DriverController@metrics');
