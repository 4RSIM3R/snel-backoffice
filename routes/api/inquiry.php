<?php

use App\Http\Controllers\Inquiry\CustomerInquiryController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "inquiry/customer", "middleware" => ["jwt.customer"]], function () {
    Route::get('get', [CustomerInquiryController::class, 'all']);
    Route::post('create', [CustomerInquiryController::class, 'create']);
});
