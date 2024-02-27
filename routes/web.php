<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('products.index');
    } else {
        return redirect()->route('login');
    }
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//  この行は不要になります。Route::resource('products', ProductController::class);  によって自動的に定義されます。
// Route::get('/products', 'ProductsController@index')->name('products.index');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', ProductController::class);
});

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

?>