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
    Route::get('api/v1/\[resource\]', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => [],
            'meta' => [
                'service_name' => 'Penjadwalan-Driver-Service',
                'api_version' => 'v1',
            ],
        ], 200);
    });

    Route::get('api/v1/\[resource\]/{id}', function () {
        return response()->json([
            'status' => 'error',
            'message' => 'Resource not found',
            'errors' => null,
        ], 404);
    });

    Route::post('api/v1/\[resource\]', function (Illuminate\Http\Request $request) {
        return response()->json([
            'status' => 'success',
            'message' => 'Resource created successfully',
            'data' => array_merge(['id' => 1], $request->all()),
            'meta' => [
                'service_name' => 'Penjadwalan-Driver-Service',
                'api_version' => 'v1',
            ],
        ], 201);
    });
});

Route::fallback(function() {
    return response()->json([
        'status' => 'error',
        'message' => 'Route not found',
        'errors' => null,
    ], 404);
});
