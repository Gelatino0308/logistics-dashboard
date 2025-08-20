<?php

use App\Http\Controllers\ProximityAlertController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::view('/proximity-form', 'dashboard.form')->name('form');

Route::get('/proximity-logs', [ProximityAlertController::class, 'showLogs'])->name('logs');

Route::post('/check-proximity', [ProximityAlertController::class, 'checkProximity'])->name('check-proximity');

