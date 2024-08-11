<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('app'));

require __DIR__ . '/auth.php';
