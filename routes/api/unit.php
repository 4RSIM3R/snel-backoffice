<?php

use App\Http\Controllers\Unit\CustomerUnitController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "unit/customer"], function () {
    Route::get('get', [CustomerUnitController::class, 'all']);
    Route::get('{id}', [CustomerUnitController::class, 'detail']);
});
