<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PhotoboxController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DownloadController;

Route::get('/', [PhotoboxController::class, 'index'])->name('photobox.index');

// Transaction Endpoints for Kiosk
Route::post('/api/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::get('/api/transactions/{uuid}/status', [TransactionController::class, 'checkStatus'])->name('transactions.status');
Route::post('/api/transactions/{uuid}/simulate-pay', [TransactionController::class, 'simulatePay'])->name('transactions.simulate_pay');
Route::post('/api/transactions/{uuid}/upload', [TransactionController::class, 'uploadResult'])->name('transactions.upload');

// Public Download Page
Route::get('/download/{uuid}', [DownloadController::class, 'show'])->name('download.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/templates', [AdminController::class, 'storeTemplate'])->name('templates.store');
        Route::delete('/templates/{template}', [AdminController::class, 'destroyTemplate'])->name('templates.destroy');
    });
});
