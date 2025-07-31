<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OilTonnageController;

Route::get('/', [OilTonnageController::class, 'index'])->name('oil.index');
Route::post('/calculate', [OilTonnageController::class, 'store'])->name('oil.store');
