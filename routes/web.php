<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompaniesController; // コントローラーを使用するために追加
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('products.index');
    } else {
        return redirect()->route('login');
    }
});

// 商品一覧ページのルート
Route::get('/products', 'ProductController@index')->name('products.index');

Route::get('/search', 'ProductController@search')->name('search');

Route::get('/create', 'ProductController@create')->name('create');

// 新規登録のためのルートを削除
Route::post('/products', 'ProductController@store')->name('store');

Route::get('/show/{product}', 'ProductController@show')->name('show');

Route::get('/edit/{product}', 'ProductController@edit')->name('edit');

Route::put('/products/{product}', 'ProductController@update')->name('update');

Route::delete('/products/{product}', 'ProductController@destroy')->name('destroy');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// 認証が必要なルートをグループ化
Route::group(['middleware' => 'auth'], function () {
    // 商品に関するCRUDルートを自動的に生成
    Route::resource('products', ProductController::class);
});