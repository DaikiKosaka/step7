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
Route::get('/products', 'ProductController@index')->name('products');

Route::get('/search', 'ProductController@search')->name('search');

Route::get('/companies', 'ProductController@create')->name('companies');

Route::post('/products', 'ProductController@store')->name('store');

Route::get('/show/{product}', 'ProductController@show')->name('show');

Route::get('/edit/{product}', 'ProductController@edit')->name('edit');

Route::put('/products/{product}', 'ProductController@update')->name('update');

Route::post('/delete', 'ProductController@destroy')->name('destroy');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', ProductController::class);
});

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');