<?php

use App\Http\Controllers\CobaController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// dashboard
Route::get('/', [FrontendController::class, 'index'])->name('index');

// login & logout
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login-auth');
Route::post('/logout',[LoginController::class, 'logout']);

// register
Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->name('register');

// page user
Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/user', [UserController::class,'index'])->name('user-index');
    Route::delete('/user/{id}',[UserController::class,'destroy'])->name('destroy');
    Route::get('search',[UserController::class, 'search'])->name('search');
});

// upload file excel
Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/file',[FilesController::class, 'index'])->name('file-index');
    Route::post('/file',[FilesController::class, 'store'])->name('file-upload');
    Route::get('/path/{id}',[FilesController::class,'path'])->name('path');
    Route::post('/file-details/{id}',[FilesController::class, 'show'])->name('file-details');
});

// Page Not Found 404
Route::fallback(function(){
    return view('404');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

