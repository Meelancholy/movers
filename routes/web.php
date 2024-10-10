<?php

use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;


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

    Route::prefix('employee')->group(function () {
        Route::get('/list', [EmployeeDashboardController::class, 'list'])->name('employee.list');
        Route::get('/', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
        Route::get('/create', [EmployeeDashboardController::class, 'create'])->name('employee.create');
        Route::post('/', [EmployeeDashboardController::class, 'store'])->name('employee.store');
        Route::get('/{id}/edit', [EmployeeDashboardController::class, 'edit'])->name('employee.edit');
        Route::put('/{id}', [EmployeeDashboardController::class, 'update'])->name('employee.update');
        Route::delete('/{id}', [EmployeeDashboardController::class, 'destroy'])->name('employee.delete');
        Route::get('/{id}', [EmployeeDashboardController::class, 'profile'])->name('employee.profile');

        Route::resource('department', DepartmentController::class);
        Route::resource('position', PositionController::class);

    });

});

require __DIR__.'/auth.php';

