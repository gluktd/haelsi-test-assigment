<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\EnumController;
use App\Http\Controllers\HealthProfessionalController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::apiResource('services', ServiceController::class);
Route::apiResource('health-professionals', HealthProfessionalController::class);
Route::apiResource('appointments', AppointmentController::class);

Route::get('visit-types', [EnumController::class, 'getVisitTypes']);
Route::get('appointment-types', [EnumController::class, 'getAppointmentTypes']);
Route::get('professional-types', [EnumController::class, 'getProfessionalTypes']);
