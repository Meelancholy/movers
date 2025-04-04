<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompensationController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayrollForecastController;
use App\Livewire\CompensationAndBenefits\Salaryadjustment;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('employee')->group(function () {
        Route::get('/list', [EmployeeDashboardController::class, 'list'])->name('employee.list');
        Route::get('/', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
        Route::get('/{id}/edit', [EmployeeDashboardController::class, 'edit'])->name('employee.edit');
        Route::put('/{id}', [EmployeeDashboardController::class, 'update'])->name('employee.update');
        Route::delete('/{id}', [EmployeeDashboardController::class, 'destroy'])->name('employee.delete');
        Route::get('/{id}', [EmployeeDashboardController::class, 'profile'])->name('employee.profile');
    });

    Route::prefix('compensation-benefits')->name('compensation.')->group(function () {
        Route::get('/', [CompensationController::class, 'index'])->name('index');
        Route::get('/addadjustment', [CompensationController::class, 'addAdjustment'])->name('addAdjustment');
        Route::delete('/adjustments/{id}', [Salaryadjustment::class, 'deleteAdjustment'])
        ->name('adjustments.destroy');
    });


    Route::prefix('payroll')->name('payroll.')->group(function () {
        Route::get('/', [PayrollController::class, 'dashboard'])->name('dashboard');
        Route::get('/generate', [PayrollController::class, 'generatePayroll'])->name('generate');
        Route::get('/records', [PayrollController::class, 'records'])->name('records');
        Route::get('/show/{employeeId}', [PayrollController::class, 'show'])->name('show');
        Route::post('/finalize/{employeeId}', [PayrollController::class, 'finalizePayroll'])->name('finalize');
        Route::get('//record/{id}', [PayrollController::class, 'viewRecord'])->name('viewRecord');
    });
    Route::get('/payroll-forecast', [PayrollForecastController::class, 'index'])->name('payroll-forecast.index');
    Route::post('/payroll-forecast/forecast', [PayrollForecastController::class, 'forecast'])->name('payroll-forecast.forecast');
});

require __DIR__.'/auth.php';

