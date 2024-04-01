<?php

use App\Http\Controllers\Profile\CustomerProfileController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "profile/customer", "middleware" => ["jwt.customer"]], function () {
    Route::get('', [CustomerProfileController::class, 'get']);
});
