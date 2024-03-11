<?php

namespace App\Http\Controllers;

use App\Models\Product; 
use App\Models\Company;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;

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
    try {
        DB::transaction(function () use ($request) {
            $request->validate([
                'product_name' => 'required',
                'company_name' => 'required', // メーカー名のバリデーションを追加
                'price' => 'required',
                'stock' => 'required',
                'comment' => 'nullable',
                'img_path' => 'nullable|image|max:2048',
            ]);

            // メーカー名からメーカーを検索
            $company = Company::where('company_name', $request->get('company_name'))->first();
            if (!$company) {
                // メーカーが存在しない場合は例外を投げる
                throw new \Exception('メーカーが見つかりません');
            }

            $product = new Product([
                'product_name' => $request->get('product_name'),
                'company_id' => $company->id, // メーカーIDを設定
                'price' => $request->get('price'),
                'stock' => $request->get('stock'),
                'comment' => $request->get('comment'),
            ]);

            // 既存の画像アップロードのコード
            if($request->hasFile('img_path')){   
                $filename = $request->img_path->getClientOriginalName();
                $filePath = $request->img_path->storeAs('public/products', $filename);
                $product->img_path = 'storage/products/' . $filename;
            }

            $product->save();
        });

        return redirect()->route('products.index')
            ->with('success', '登録しました');
    } catch (\Exception $e) {
        // エラー時の処理
        return redirect()->back()->with('error', 'エラーです' . $e->getMessage());
    }
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
    try {
        DB::transaction(function () use ($request, $product){
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->save();
    });
        return redirect()->route('products.index')
            ->with('success', '更新しました');
    } catch (\Exception $e) {
        // エラー時の処理
        return redirect()->back()->with('error', 'エラーです' . $e->getMessage());
    }
}
    public function destroy(Product $product)
    {
    try {
        DB::transaction(function () use ($product) {
            $product->delete();
        });

        return redirect()->route('products.index')
            ->with('success', '削除しました');
    } catch (\Exception $e) {
        // エラー時の処理
        return redirect()->back()->with('error', 'エラーです' . $e->getMessage());
    }
    }
}

