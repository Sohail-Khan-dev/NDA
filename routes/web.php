<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use \App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('index');
});
// routes/web.php


Route::get('/', [AuthController::class, 'register'])->name('users.register');
Route::post('/users', [AuthController::class, 'login'])->name('users.login');

