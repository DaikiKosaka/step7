<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function create()
{
    $companies = Company::all();
    return view('products.create', compact('companies'));
}


public function update(Request $request, Product $product)
{
    try {
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->save();

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    } catch (\Exception $e) {
        // エラー時の処理
        return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
    }
}
}
