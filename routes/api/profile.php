<?php

use App\Http\Controllers\Profile\CustomerProfileController;
use App\Http\Controllers\Profile\EmployeeProfileController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "profile/customer", "middleware" => ["jwt.customer"]], function () {
    Route::get('', [CustomerProfileController::class, 'get']);
});

Route::group(["prefix" => "profile/employee", "middleware" => ["jwt.customer"]], function () {
    Route::get('', [EmployeeProfileController::class, 'get']);
});
