<?php

use App\Http\Controllers\Auth\AccountSettingController;
use App\Http\Controllers\Auth\LogsController;
use App\Http\Controllers\Auth\NotificationsController;
use App\Http\Controllers\Auth\ReportsController;
use App\Http\Controllers\Auth\UsersController;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\LogInferencedImageController;
use App\Http\Controllers\Guest\SignInController;
use App\Http\Controllers\Guest\SignupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [SignInController::class, 'index'])->name('signin');
Route::post('/signin/process', [SignInController::class, 'processSignin'])->name('signin.process');
Route::get('/signup', [SignupController::class, 'viewSignup'])->name('signup');
Route::post('/signup/process', [SignupController::class, 'signupProcess']);
Route::get('/signout', [SignInController::class, 'signout'])->name('signout');

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('is_auth');
Route::post('/log-inference-image', [LogInferencedImageController::class, 'logImage'])->name('log.inference-image')->middleware('is_auth');

// auth
Route::resource('/inferenced-images', LogsController::class)->middleware('is_auth');
Route::resource("/users", UsersController::class)->middleware(['is_auth', 'is_admin']);
Route::resource('/account-setting', AccountSettingController::class)->middleware('is_auth');
Route::resource('/notifications', NotificationsController::class)->middleware('is_auth');
Route::get('/user-notification-count', [NotificationsController::class, 'getUserNotificationCount'])->middleware('is_auth');
Route::put('/set-read/{id}', [NotificationsController::class, 'setRead'])->middleware('is_auth');
Route::resource('/reports', ReportsController::class)->middleware('is_auth');
Route::get('/get-chart-data', [ReportsController::class, 'getChartData'])->middleware('is_auth');

Route::get("/get-file", function (Request $request) {

    if (!$request->filled('path')) return null;

    $type = urldecode($request->type);

    $path = urldecode($request->path);

    if ($type == "img-src") {
        if (!Storage::disk('local')->exists($path)) return response(null, 404);

        $file = Storage::disk('local')->path($path);

        return response()->file($file, ['Content-Type' => Storage::disk('local')->mimeType($path)]);
    }
})->name('get.file')->middleware('is_auth');