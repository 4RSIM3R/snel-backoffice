<?php

use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\EmployeeAuthController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "auth/customer"], function () {
    Route::post('login', [CustomerAuthController::class, 'login']);
    Route::post('refresh', [CustomerAuthController::class, 'refresh']);

    Route::group(["middleware" => [""]], function () {
        Route::post('logout', [CustomerAuthController::class, 'logout']);
    });

});

Route::group(["prefix" => "auth/employee"], function () {
    Route::post('login', [EmployeeAuthController::class, 'login']);
    Route::post('refresh', [EmployeeAuthController::class, 'refresh']);
    Route::post('logout', [EmployeeAuthController::class, 'logout']);
});
