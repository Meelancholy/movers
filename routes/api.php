<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;

Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Employee CRUD
        Route::apiResource('employees', EmployeeController::class);

        // Employee filters
        Route::get('/employees/search/{query}', [EmployeeController::class, 'search']);
        Route::get('/employees/department/{department}', [EmployeeController::class, 'byDepartment']);
    });
});
