<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Models\Task;

Route::controller(AuthController::class)->group(
    function () {
        Route::post('/auth/register', 'register');
        Route::post('/auth/login', 'authenticate');
    }
);

Route::post('/auth/logout', [AuthController::class, 'deauthenticate'])->middleware('auth:sanctum');

Route::controller(TaskController::class)->group(
    function () {
        Route::post('task/store', 'store');
        Route::post('task/update', 'update');
    }
)->middleware('auth:sanctum');
