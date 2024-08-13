<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/top-spender', [CustomerController::class, 'topSpender']);
Route::get('/top-orderer', [CustomerController::class, 'topOrderer']);
