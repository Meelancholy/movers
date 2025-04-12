<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompensationController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayrollForecastController;
use App\Livewire\CompensationAndBenefits\Salaryadjustment;
use App\Http\Controllers\landingpageController;
use App\Http\Controllers\Auth\TwoFactorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VirtualAssistant;

Route::get('/', [landingpageController::class, 'welcome'])->name('welcome');
Route::get('/login', function () {
    return view('auth.login');
});

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function () {
    Route::get('/two-factor', [TwoFactorController::class, 'show'])->name('two-factor.show');
    Route::post('/two-factor', [TwoFactorController::class, 'verify'])->name('two-factor.verify');
    Route::post('/two-factor/resend', [TwoFactorController::class, 'resend'])->name('two-factor.resend');
});

Route::middleware(['auth', 'twofactor'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
    Route::post('/assistant', [VirtualAssistant::class, 'virtualassistant'])->name('virtualassistant');
});

