<?php

use App\Http\Controllers\Auth\LogsController;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\LogInferencedImageController;
use App\Http\Controllers\Guest\SignInController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/signin', [SignInController::class, 'index'])->name('signin');
Route::post('/signin/process', [SignInController::class, 'processSignin'])->name('signin.process');
Route::get('signout', [SignInController::class, 'signout'])->name('signout');
Route::post('/log-inference-image', [LogInferencedImageController::class, 'logImage'])->name('log.inference-image');

// auth
Route::resource('/inferenced-images', LogsController::class)->middleware('is_auth');
Route::get("/get-file", function(Request $request){

    if(!$request->filled('path')) return null;

    $type = urldecode($request->type);

    $path = urldecode($request->path);

    if($type == "img-src"){
        if(!Storage::disk('local')->exists($path)) return response(null, 404);

        $file = Storage::disk('local')->path($path);

        return response()->file($file, ['Content-Type' => Storage::disk('local')->mimeType($path)]);
    }


})->name('get.file')->middleware('is_auth');
// Route
