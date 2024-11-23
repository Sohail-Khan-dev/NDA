<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;

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
Auth::routes(['verify' => true]);

Route::get('send-email',[EmailController::class,"sendEmail"])->name('send-email');


Auth::routes();
Route::get('/',[AuthController::class,'index'] )->middleware('verified');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
