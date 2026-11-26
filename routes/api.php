<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MejaController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\StaffController;
use Illuminate\Support\Facades\Route;

// ---------- Publik (tanpa token) ----------
Route::post('/login', [AuthController::class, 'login']);
Route::get('/menu', [MenuController::class, 'index']);
Route::get('/menu/{menu}', [MenuController::class, 'show']);

// ---------- Perlu token (Admin & Pegawai) ----------
Route::middleware('api.token')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/menu', [MenuController::class, 'store']);
    Route::match(['put', 'patch', 'post'], '/menu/{menu}', [MenuController::class, 'update']);
    Route::delete('/menu/{menu}', [MenuController::class, 'destroy']);

    Route::apiResource('meja', MejaController::class)
        ->parameters(['meja' => 'meja'])
        ->names('api.meja');

    // ---------- Khusus Admin ----------
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('staff', StaffController::class)
            ->parameters(['staff' => 'staff'])
            ->names('api.staff');
    });
});