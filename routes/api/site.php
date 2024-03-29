<?php

use App\Http\Controllers\Site\CustomerSiteController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "site/customer", "middleware" => ["jwt.customer"]], function () {
    Route::get('get', [CustomerSiteController::class, 'all']);
    Route::get('{id}', [CustomerSiteController::class, 'detail']);
});
