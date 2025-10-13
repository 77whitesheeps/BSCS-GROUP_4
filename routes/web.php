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
use App\Http\Controllers\MonthlyReportController;
use App\Http\Controllers\PlantReportController;
use App\Http\Controllers\GardenPlannerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalculationHistoryController;
use App\Http\Controllers\HelpController;

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
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Square Planting Calculator
    Route::get('/planting-calculator', [PlantingCalculatorController::class, 'index'])->name('planting.calculator');
    Route::post('/calculate-plants', [PlantingCalculatorController::class, 'calculate'])->name('calculate.plants');

    // Quincunx Calculator routes
    Route::get('/quincunx-calculator', [QuincunxCalculatorController::class, 'index'])->name('quincunx.calculator');
    Route::post('/calculate-quincunx', [QuincunxCalculatorController::class, 'calculate'])->name('calculate.quincunx');

    // Triangular Calculator routes
    Route::get('/triangular-calculator', [TriangularCalculatorController::class, 'index'])->name('triangular.calculator');
    Route::post('/triangular-calculator/calculate', [TriangularCalculatorController::class, 'calculate'])->name('triangle.calculate');
    
    // (Removed: Usage Statistics routes)
Route::get('/monthly-reports', [MonthlyReportController::class, 'index'])->name('monthly-reports.index');
Route::post('/monthly-report/generate', [MonthlyReportController::class, 'generate'])->name('monthly-report.generate');
Route::get('/monthly-report/api/{month?}', [MonthlyReportController::class, 'apiData'])->name('monthly-report.api');

// Print report route  
Route::get('/print-report', [PlantReportController::class, 'printReport'])->name('print.report');

    // Calculation History routes
    Route::get('/calculations/history', [CalculationHistoryController::class, 'index'])->name('calculations.history');
    Route::get('/calculations/saved', [CalculationHistoryController::class, 'saved'])->name('calculations.saved');
    Route::get('/calculations/export', [CalculationHistoryController::class, 'exportPage'])->name('calculations.export');
    Route::post('/calculations/export', [CalculationHistoryController::class, 'export']);
    Route::post('/calculations/{id}/save', [CalculationHistoryController::class, 'save'])->name('calculations.save');
    Route::delete('/calculations/{id}', [CalculationHistoryController::class, 'destroy'])->name('calculations.destroy');

    // Tools routes
    Route::prefix('tools')->name('tools.')->group(function () {
        Route::get('/weather', function () { return view('tools.weather'); })->name('weather');
    });

    // Garden Planner routes
    Route::get('/garden-planner', [GardenPlannerController::class, 'index'])->name('garden.planner');
    Route::get('/garden-planner/{id}', [GardenPlannerController::class, 'show'])->name('garden.planner.show');
    Route::post('/garden-planner/save', [GardenPlannerController::class, 'save'])->name('garden.planner.save');
    Route::put('/garden-planner/{id}', [GardenPlannerController::class, 'update'])->name('garden.planner.update');
    Route::delete('/garden-planner/{id}', [GardenPlannerController::class, 'delete'])->name('garden.planner.delete');
    // Enhanced garden planner features
    Route::post('/garden-planner/{id}/import-calculation', [GardenPlannerController::class, 'importCalculation'])->name('garden.planner.import-calculation');
    Route::patch('/garden-planner/{id}/task-status', [GardenPlannerController::class, 'updateTaskStatus'])->name('garden.planner.task-status');
    Route::get('/garden-planner/statistics', [GardenPlannerController::class, 'getStatistics'])->name('garden.planner.statistics');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/preferences', [ProfileController::class, 'preferences'])->name('preferences');
    Route::post('/preferences', [ProfileController::class, 'updatePreferences'])->name('preferences.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password.update');

    // Help routes
    Route::get('/help', [HelpController::class, 'index'])->name('help.support');
});