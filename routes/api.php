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

Route::middleware(VerifyApiKey::class)->group(function () {
    Route::get('api/v1/schedules', [ScheduleController::class, 'index']);
    Route::get('api/v1/schedules/{id}', [ScheduleController::class, 'show']);
    Route::post('api/v1/schedules', [ScheduleController::class, 'store']);
    Route::get('api/v1/\[resource\]', [ScheduleController::class, 'index']);
    Route::get('api/v1/\[resource\]/{id}', [ScheduleController::class, 'show']);
    Route::post('api/v1/\[resource\]', [ScheduleController::class, 'store']);
});

Route::fallback(function() {
    return response()->json([
        'status' => 'error',
        'message' => 'Route not found',
        'errors' => null,
    ], 404);
});
