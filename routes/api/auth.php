<?php

use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\EmployeeAuthController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "auth/customer"], function () {
    Route::post('login', [CustomerAuthController::class, 'login']);

    Route::group(["middleware" => ["jwt.customer"]], function () {
        Route::post('logout', [CustomerAuthController::class, 'logout']);
    });

});

Route::group(["prefix" => "auth/employee"], function () {
    Route::post('login', [EmployeeAuthController::class, 'login']);

    Route::group(["middleware" => ["jwt.employee"]], function () {
        Route::post('logout', [EmployeeAuthController::class, 'logout']);
    });


});
