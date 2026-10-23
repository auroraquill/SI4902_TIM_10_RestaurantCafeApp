<?php

use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffEditController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('staff.index'));
Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
Route::get('/staff/{staff}/edit', [StaffEditController::class, 'edit'])->name('staff.edit');
Route::put('/staff/{staff}', [StaffEditController::class, 'update'])->name('staff.update');
Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');