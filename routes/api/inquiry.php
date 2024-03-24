<?php

use App\Http\Controllers\Auth\CustomerAuthController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "inquiry/customer"], function () {
    Route::get('get', [CustomerAuthController::class, 'login']);
    Route::post('create', [CustomerAuthController::class, 'refresh']);
});
