<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Main Dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [UserController::class, 'dashboard']);

// User Management
Route::get('/create-user', [UserController::class, 'createUser']);

// Settings Management
Route::get('/settings-form', [UserController::class, 'showForm']);
Route::post('/save-settings', [UserController::class, 'saveSettings']);
Route::get('/get-settings', [UserController::class, 'getSettings']);
Route::get('/get-single', [UserController::class, 'getSingle']);
Route::get('/update-setting', [UserController::class, 'updateSetting']);
Route::get('/delete-setting', [UserController::class, 'deleteSetting']);

// History & Analytics
Route::get('/settings-history', [UserController::class, 'settingsHistory']);
Route::get('/reset-settings', [UserController::class, 'resetSettings']);
Route::get('/analytics', [UserController::class, 'analytics']);
Route::get('/export-settings', [UserController::class, 'exportSettings']);
Route::post('/import-settings', [UserController::class, 'importSettings']);