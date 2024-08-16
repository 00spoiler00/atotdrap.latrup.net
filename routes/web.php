<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/changelog', 'App\Http\Controllers\ChangelogController@show');
Route::get('/{any}', fn () => view('app'))->where('any', '.*');
