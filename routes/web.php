<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('clear-cache', function () {
        Artisan::call('optimize:clear');

        return back()->with('status', 'Cache cleared successfully.');
    })->name('clear-cache');

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('audios', AudioController::class)->except('show');
});
