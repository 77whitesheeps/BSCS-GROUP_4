<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

Route::get('/', function () {
    return view('register');
});

Route::get('/register', [RegistrationController::class, 'showForm']);
Route::post('/register', [RegistrationController::class, 'register']);