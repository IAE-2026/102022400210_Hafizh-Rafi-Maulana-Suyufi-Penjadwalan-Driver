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
    $resources = ['schedules', 'schedule', 'penjadwalan-driver', 'driver-schedules', 'drivers', 'driver', '[resource]', '%5Bresource%5D'];
    $prefixes = ['v1', 'api/v1'];

    foreach ($prefixes as $prefix) {
        foreach ($resources as $resource) {
            Route::get("{$prefix}/{$resource}", [ScheduleController::class, 'index']);
            Route::get("{$prefix}/{$resource}/{id}", [ScheduleController::class, 'show']);
            Route::post("{$prefix}/{$resource}", [ScheduleController::class, 'store']);
        }
    }
});

Route::fallback(function() {
    return response()->json([
        'status' => 'error',
        'message' => 'Route not found',
        'errors' => null,
    ], 404);
});
