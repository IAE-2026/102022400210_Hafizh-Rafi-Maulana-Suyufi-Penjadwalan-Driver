<?php

use App\Http\Controllers\Api\V1\ScheduleController;
use App\Http\Middleware\VerifyApiKey;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Penjadwalan Driver Service
|--------------------------------------------------------------------------
|
| Service B: Penjadwalan Driver
| NIM: 102022400210 - Hafizh Rafi Maulana Suyufi
|
| All endpoints require X-IAE-KEY header with value: 102022400210
|
*/

Route::prefix('v1')->middleware(VerifyApiKey::class)->group(function () {
    // Collection: Get all schedules
    Route::get('/schedules', [ScheduleController::class, 'index']);

    // Resource: Get specific schedule
    Route::get('/schedules/{id}', [ScheduleController::class, 'show']);

    // Action: Create new schedule
    Route::post('/schedules', [ScheduleController::class, 'store']);
});
