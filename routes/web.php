<?php

use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\CompensationController;
use App\Http\Controllers\PayrollController;
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

        Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
        Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
        Route::post('/department', [DepartmentController::class, 'store'])->name('department.store');
        Route::get('/department/{id}/edit', [DepartmentController::class, 'edit'])->name('department.edit');
        Route::put('/department/{id}', [DepartmentController::class, 'update'])->name('department.update');
        Route::delete('/department/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');

        Route::get('/position', [PositionController::class, 'index'])->name('position.index');
        Route::get('/position/create', [PositionController::class, 'create'])->name('position.create');
        Route::post('/position', [PositionController::class, 'store'])->name('position.store');
        Route::get('/position/{id}/edit', [PositionController::class, 'edit'])->name('position.edit');
        Route::put('/position/{id}', [PositionController::class, 'update'])->name('position.update');
        Route::delete('/position/{id}', [PositionController::class, 'destroy'])->name('position.destroy');
    });

    Route::prefix('compensation')->name('compensation.')->group(function () {
        Route::get('/', [CompensationController::class, 'index'])->name('index');
        Route::get('/create-contribution', [CompensationController::class, 'createContribution'])->name('create_contribution');
        Route::post('/store-contribution', [CompensationController::class, 'storeContribution'])->name('store_contribution');
        Route::get('/create-deduction', [CompensationController::class, 'createDeduction'])->name('create_deduction');
        Route::post('/store-deduction', [CompensationController::class, 'storeDeduction'])->name('store_deduction');
        Route::get('/create-bonus', [CompensationController::class, 'createBonus'])->name('create_bonus');
        Route::post('/store-bonus', [CompensationController::class, 'storeBonus'])->name('store_bonus');
        Route::get('/edit/{id}', [CompensationController::class, 'editEmployee'])->name('edit');
        Route::put('/update/{id}', [CompensationController::class, 'updateEmployee'])->name('update');
        Route::get('/view/{id}', [CompensationController::class, 'viewEmployee'])->name('view');
        Route::delete('/deduction/{id}', [CompensationController::class, 'deleteDeduction'])->name('deduction.delete');
        Route::delete('/bonus/{id}', [CompensationController::class, 'deleteBonus'])->name('bonus.delete');
    });

    Route::group(['prefix' => 'payroll', 'as' => 'payroll.'], function () {
        Route::get('/generate', [PayrollController::class, 'create'])->name('create');
        Route::post('/generate', [PayrollController::class, 'store'])->name('store');
        Route::get('/records', [PayrollController::class, 'records'])->name('records');
        Route::get('/{id}', [PayrollController::class, 'show'])->name('show');
    });


});

require __DIR__.'/auth.php';

