<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Route::get('users', [\App\Http\Controllers\UserController::class, 'index']);
// Route::post('users', [\App\Http\Controllers\UserController::class, 'store']);
Route::apiResource('/users', UserController::class);
