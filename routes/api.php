<?php

use App\Http\Controllers\IoTController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// IoT Device Routes
Route::post('/door/status', [UserController::class, 'doorStatus']);
