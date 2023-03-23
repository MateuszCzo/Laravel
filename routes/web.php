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
    Route::resource('products', ProductController::class);
    
    Route::get('/users/list', [UserController::class, 'index']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

/*
Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('auth')->middleware('varified');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('auth')->middleware('varified');
Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('auth')->middleware('varified');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show')->middleware('auth')->middleware('varified');
Route::get('/products/edit/{product}', [ProductController::class, 'edit'])->name('products.edit')->middleware('auth')->middleware('varified');
Route::post('/products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('auth')->middleware('varified');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('auth')->middleware('varified');
*/

Route::get('/hello', [HelloWorldController::class, 'show']);
