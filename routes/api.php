<?php

use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function(){
    Route::post('user/register', 'register');
    Route::post('user/login', 'login');
});
        
Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('expenses', ExpenseController::class);
});