<?php

use App\Http\Controllers\Ticket\CustomerTicketController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "ticket/customer",  "middleware" => ["jwt.customer"]], function () {
    Route::get('get', [CustomerTicketController::class, 'all']);
    Route::get('detail/{id}', [CustomerTicketController::class, 'detail']);
});

Route::group(["prefix" => "ticket/employee"], function () {

});
