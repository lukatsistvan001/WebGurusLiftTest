<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LiftController;

Route::get('/', [LiftController::class, 'index']);
// Route::get('/move-lift/{lift}/{targetFloor}', [LiftController::class, 'moveLift']);
Route::post('/move-lift', [LiftController::class, 'moveLift']);
Route::post('/call-nearest-lift', [LiftController::class, 'callNearestLift']);
