<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Product モデルをインポート

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Product モデルを使用
        return view('products', ['products' => $products]);
    }
}
