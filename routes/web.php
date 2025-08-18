<?php

use App\Http\Controllers\ProximityAlertController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/proximity-form', function () {
    return view('dashboard.form');
});

Route::post('/check-proximity', [ProximityAlertController::class, 'checkProximity'])->name('check.proximity');

