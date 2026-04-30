<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Default Laravel welcome page
Route::get('/', function () {
    return view('welcome');
});

// Create new user
Route::get('/create-user', [UserController::class, 'createUser']);

// Add settings to user
Route::get('/add-settings', [UserController::class, 'addSettings']);

// Get all settings
Route::get('/get-settings', [UserController::class, 'getSettings']);

// Get single setting
Route::get('/get-single', [UserController::class, 'getSingle']);

// Update setting
Route::get('/update-setting', [UserController::class, 'updateSetting']);

// Delete setting
Route::get('/delete-setting', [UserController::class, 'deleteSetting']);

Route::get('/settings-form', [UserController::class, 'showForm']);
Route::post('/save-settings', [UserController::class, 'saveSettings']);
Route::get('/settings-history', [UserController::class, 'settingsHistory']);
Route::get('/reset-settings', [UserController::class, 'resetSettings']);