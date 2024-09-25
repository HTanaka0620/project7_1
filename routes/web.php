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

// 初期画面（welcomeページ）のルート
Route::get('/', function () {
    return view('welcome');
});

// 認証機能のルート
Auth::routes();

// ホーム画面のルート
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 商品一覧表示
Route::get('/product_list', [ProductController::class, 'List'])->name('product_list');

// 新規登録フォームの表示
Route::get('/show_Registration', [ProductController::class, 'ChooseCompanies'])->name('show_Registration');

// 商品の新規登録処理
Route::post('/Registration', [ProductController::class, 'Regist'])->name('Registration');

// 商品詳細表示
Route::get('/product_details/{id}', [ProductController::class, 'show_details'])->name('product_details');

// 商品編集フォームの表示
Route::get('/product_edit/{id}', [ProductController::class, 'show_edit'])->name('product_edit');

// 商品の更新処理
Route::put('/product_update/{id}', [ProductController::class, 'update'])->name('product_update');

// 商品の削除処理
Route::delete('/product_destroy/{id}', [ProductController::class, 'destroy'])->name('product_destroy');
