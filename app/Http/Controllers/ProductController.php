<?php

namespace App\Http\Controllers;

use App\Models\Product; 
use App\Models\Company;
use Illuminate\Http\Request; 

class ProductController extends Controller
{
    
    public function index(Request $request)
{
    $query = Product::query();

    if($request->has('keyword')) {
        $keyword = $request->input('keyword');
        $query->where('product_name', 'like', "%$keyword%");
    }

    if($request->has('company_id')) {
        $companyId = $request->input('company_id');
        if (is_numeric($companyId)) {
            $query->where('company_id', $companyId);
        } else {
            $company = Company::where('company_name', $companyId)->first();
            if ($company) {
                $query->where('company_id', $company->id);
            }
        }
    }

    $products = $query->paginate(10);
    $companies = Company::all();

    return view('products', compact('products', 'companies'));
}

    public function create()
    {
        $companies = Company::all();

        return view('companies', compact('companies'));
    }

    public function store(Request $request)
{
    $request->validate([
        'product_name' => 'required',
        'company_id' => 'required',
        'price' => 'required',
        'stock' => 'required',
        'comment' => 'nullable',
        'img_path' => 'nullable|image|max:2048',
    ]);

    $product = new Product([
        'product_name' => $request->get('product_name'),
        'company_id' => $request->get('company_id'),
        'price' => $request->get('price'),
        'stock' => $request->get('stock'),
        'comment' => $request->get('comment'),
    ]);

    if($request->hasFile('img_path')){   
        $filename = $request->img_path->getClientOriginalName();
        $filePath = $request->img_path->storeAs('public/products', $filename);
        $product->img_path = 'storage/products/' . $filename;
    }

    $product->save();

    return redirect()->route('products.index')
        ->with('success', 'Product created successfully');
}

    public function show(Product $product)
    {
        return view('show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        $companies = Company::all();

        return view('edit', compact('product', 'companies'));
    }

    public function update(Request $request, Product $product)
    {
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
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/products');
    }

    
}

