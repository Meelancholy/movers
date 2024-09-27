<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('hr1.dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('employees', EmployeeController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('positions', PositionController::class);


    Route::get('/driver', function () {
        return view('livewire.driver-management');
    })->name('driver-management');

    Route::get('/payroll', function () {
        return view('livewire.payroll');
    })->name('payroll');

    Route::get('/payroll-records', function () {
        return view('livewire.payroll-records');
    })->name('payroll-records');

    Route::get('/bonus-deduction', function () {
        return view('livewire.bonus-deduction');
    })->name('bonus-deduction');
});


require __DIR__.'/auth.php';
