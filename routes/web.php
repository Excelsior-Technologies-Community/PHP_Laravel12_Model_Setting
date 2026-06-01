<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

Route::get('/create-user', [UserController::class, 'createUser']);

Route::get('/settings-form', [UserController::class, 'showForm']);
Route::post('/save-settings', [UserController::class, 'saveSettings'])->name('settings.update');
Route::post('/settings/bulk-update', [UserController::class, 'bulkUpdateAjax'])->name('settings.bulkUpdate');
Route::get('/settings/search', [UserController::class, 'search'])->name('settings.search');
Route::get('/get-settings', [UserController::class, 'getSettings']);
Route::get('/get-single', [UserController::class, 'getSingle']);
Route::get('/update-setting', [UserController::class, 'updateSetting']);
Route::get('/delete-setting', [UserController::class, 'deleteSetting']);

Route::get('/settings-history', [UserController::class, 'settingsHistory']);
Route::get('/reset-settings', [UserController::class, 'resetSettings']);
Route::get('/analytics', [UserController::class, 'analytics']);
Route::get('/export-settings', [UserController::class, 'exportSettings']);
Route::post('/import-settings', [UserController::class, 'importSettings']);