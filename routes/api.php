<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']); // this will limit user request upto 5 in a minute
Route::post('/login', [AuthController::class, 'login']);
Route::get('/users', [AuthController::class, 'fetchAllUsers']);
