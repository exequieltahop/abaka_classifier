<?php

use App\Http\Controllers\Auth\LogsController;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\SignInController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/signin', [SignInController::class, 'index'])->name('signin');
Route::post('/signin/process', [SignInController::class, 'processSignin'])->name('signin.process');
Route::get('signout', [SignInController::class, 'signout'])->name('signout');

// auth
Route::resource('/logs', LogsController::class)->middleware('is_auth');