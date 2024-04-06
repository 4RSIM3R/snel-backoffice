<?php

use App\Http\Controllers\Ticket\CustomerTicketController;
use App\Http\Controllers\Ticket\EmployeeTicketController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "ticket/customer",  "middleware" => ["jwt.customer"]], function () {
    Route::get('get', [CustomerTicketController::class, 'all']);
    Route::get('detail/{id}', [CustomerTicketController::class, 'detail']);
    Route::get('update/{id}', [CustomerTicketController::class, 'update']);
});

Route::group(["prefix" => "ticket/employee"], function () {
    Route::get('get', [EmployeeTicketController::class, 'all']);
    Route::get('detail/{id}', [EmployeeTicketController::class, 'detail']);
});
