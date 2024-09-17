<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('tasks', TaskController::class);
    Route::put('/tasks/{id}/complete', [TaskController::class, 'complete']);
    Route::post('/reports/tasks', [ReportController::class, 'generateTasksReport']);
    Route::get('/reports/download', [ReportController::class, 'downloadReport']);
});