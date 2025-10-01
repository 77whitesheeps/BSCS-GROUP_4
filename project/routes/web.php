<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlantingCalculatorController;
use App\Http\Controllers\QuincunxCalculatorController;
use App\Http\Controllers\TriangularCalculatorController;

// Public routes
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});
Route::get('/welcome', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/register', [RegistrationController::class, 'showForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register']);
Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password reset routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Google OAuth routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/planting-calculator', [PlantingCalculatorController::class, 'index'])->name('planting.calculator');
    Route::post('/calculate-plants', [PlantingCalculatorController::class, 'calculate'])->name('calculate.plants');
    
    // Quincunx Calculator routes
    Route::get('/quincunx-calculator', [QuincunxCalculatorController::class, 'index'])->name('quincunx.calculator');
    Route::post('/calculate-quincunx', [QuincunxCalculatorController::class, 'calculate'])->name('calculate.quincunx');
    
    // Triangular Calculator routes
    Route::get('/triangular-calculator', [TriangularCalculatorController::class, 'index'])->name('triangular.calculator');
Route::post('/triangular-calculator/calculate', [TriangularCalculatorController::class, 'calculate'])->name('triangle.calculate');

});

