<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;



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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/example', [ExampleController::class, 'show']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/show_Registration', [App\Http\Controllers\ProductController::class, 'ChooseCompanies'])->name('show_Registration');

Route::get('/product_list', [App\Http\Controllers\ProductController::class, 'List'])->name('product_list');

Route::post('/Registration', [App\Http\Controllers\ProductController::class, 'Regist'])->name('Registration');

Route::get('/product_details/{id}', [App\Http\Controllers\ProductController::class, 'show_details'])->name('product_details');

Route::get('/product_edit/{id}', [App\Http\Controllers\ProductController::class, 'show_edit'])->name('product_edit');

Route::put('/product_update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product_update');

Route::delete('/product_destroy/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product_destroy');
