<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecretController;

/**
 *
 * Route::resource contains all REST routes, currently limited for GET and POST requests.
 */

Route::resource('secret', SecretController::class);

