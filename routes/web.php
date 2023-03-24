<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloWorldController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;

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

Route::get('/', [WelcomeController::class, 'index']);


Auth::routes(['verify' => true]);


Route::middleware(['auth', 'verified'])->group(function() {
    Route::middleware(['can:isAdmin'])->group(function() {
        Route::resource('products', ProductController::class);
        Route::get('/users/list', [UserController::class, 'index']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('/hello', [HelloWorldController::class, 'show']);
