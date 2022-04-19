<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FilesController;
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
Route::get('/file/download/{filename}', [FilesController::class, 'download'])->name('file.download');

// dashboard
Route::get('/', [DashboardController::class, 'index'])->name('index');
// profile
Route::get('/profile/{id}',[UserController::class, 'profile'])->name('profile');


// login & logout
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login-auth');
Route::post('/logout',[LoginController::class, 'logout']);

// register
Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->name('register');


// page user
Route::middleware(['auth:sanctum', 'verified','admin'])->group(function(){
    Route::get('/user', [UserController::class,'index'])->name('user-index');
    Route::delete('/user/{id}',[UserController::class,'destroy'])->name('destroy');
    Route::get('user/edit/{id}',[UserController::class, 'edit'])->name('edit-user');
    Route::put('edit/{id}',[UserController::class, 'update'])->name('update-user');
});

// upload file excel
Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/file',[FilesController::class, 'index'])->name('file-index');
    Route::post('/file',[FilesController::class, 'store'])->name('file-upload');
    Route::post('/file/edit',[FilesController::class, 'json_edit'])->name('json_edit');
    Route::get('/path/{id}',[FilesController::class,'path'])->name('path');
    Route::get('/file-details/{id}',[FilesController::class, 'ShowAndDestroy'])->name('file-details');
    Route::delete('/file-details/{id}',[FilesController::class,'destroy'])->name('destroy');
    Route::post('/similarity/{id}',[FilesController::class,'similarity'])->name('similarity');
});

// Page Not Found 404
Route::fallback(function(){
    return view('404');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

