<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\HealthProfessionalController;
use App\Http\Controllers\AppointmentController;

Route::apiResource('services', ServiceController::class);
Route::apiResource('health-professionals', HealthProfessionalController::class);
Route::apiResource('appointments', AppointmentController::class);
