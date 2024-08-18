<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/frontVersion', fn () => response()->json(['version' => '1.0.0']));
Route::get('/dashboard', 'App\Http\Controllers\GenericController@dashboard');
Route::get('/test', 'App\Http\Controllers\TestController');

Route::get('/race/upcoming', 'App\Http\Controllers\RaceController@upcoming');
Route::get('/race/{race}', 'App\Http\Controllers\RaceController@show');

Route::get('/track/{track}', 'App\Http\Controllers\TrackController@show');
Route::get('/track/{track}/hotlaps', 'App\Http\Controllers\TrackController@hotlaps');

Route::get('/enrollment/{enrollment}', 'App\Http\Controllers\EnrollmentController@show');
Route::get('/hotlap', 'App\Http\Controllers\HotlapController@index');

Route::get('/driver/', 'App\Http\Controllers\DriverController@index');
Route::get('/driver/{driver}', 'App\Http\Controllers\DriverController@show');
Route::get('/driver/{driver}/hotlaps', 'App\Http\Controllers\DriverController@hotlaps');
Route::get('/driver/{driver}/metrics', 'App\Http\Controllers\DriverController@metrics');
