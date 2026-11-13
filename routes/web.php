<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffEditController;
use Illuminate\Support\Facades\Route;

// Belum login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
});

// Sudah login (admin & pegawai)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', fn () => auth()->user()->isAdmin()
        ? redirect()->route('staff.index')
        : redirect()->route('staff.profil'));

    // Pegawai: R (profil sendiri)
    Route::get('/profil', [StaffController::class, 'profil'])->name('staff.profil');
});

// Admin: C R U D penuh
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{staff}/edit', [StaffEditController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{staff}', [StaffEditController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
});
