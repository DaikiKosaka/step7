<?php

// まずは読込。ProductとCompanyの情報
namespace App\Http\Controllers;

use App\Models\Product; // Productモデルを現在のファイルで使用できるようにするための宣言です。
use App\Models\Company; // Companyモデルを現在のファイルで使用できるようにするための宣言です。
use Illuminate\Http\Request; // Requestクラスという機能を使えるように宣言します
// Requestクラスはブラウザに表示させるフォームから送信されたデータをコントローラのメソッドで引数として受け取ることができます。

class ProductController extends Controller //コントローラークラスを継承します（コントローラーの機能が使えるようになります）
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
        // 商品作成画面で会社の情報が必要なので、全ての会社の情報を取得します。
        $companies = Company::all();

        // 商品作成画面を表示します。その際に、先ほど取得した全ての会社情報を画面に渡します。
        return view('companies', compact('companies'));
    }

    // 送られたデータをデータベースに保存するメソッドです
    public function store(Request $request)
{
    //  バリデーションルールを定義
    $request->validate([
        'product_name' => 'required',
        'company_id' => 'required',
        'price' => 'required',
        'stock' => 'required',
        'comment' => 'nullable',
        'img_path' => 'nullable|image|max:2048',
    ]);

    //  新しいProductインスタンスを作成
    $product = new Product([
        'product_name' => $request->get('product_name'),
        'company_id' => $request->get('company_id'),
        'price' => $request->get('price'),
        'stock' => $request->get('stock'),
        'comment' => $request->get('comment'),
    ]);

    //  画像がアップロードされた場合、それを保存
    if($request->hasFile('img_path')){   
        $filename = $request->img_path->getClientOriginalName();
        $filePath = $request->img_path->storeAs('public/products', $filename);
        $product->img_path = 'storage/products/' . $filename;
    }

    //  データベースに新規レコードを保存
    $product->save();

    //  一覧画面にリダイレクト
    return redirect()->route('products.index')
        ->with('success', 'Product created successfully');
}

    public function show(Product $product)
    //(Product $product) 指定されたIDで商品をデータベースから自動的に検索し、その結果を $product に割り当てます。
    {
        // 商品詳細画面を表示します。その際に、商品の詳細情報を画面に渡します。
        return view('show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        // 商品編集画面で会社の情報が必要なので、全ての会社の情報を取得します。
        $companies = Company::all();

        // 商品編集画面を表示します。その際に、商品の情報と会社の情報を画面に渡します。
        return view('edit', compact('product', 'companies'));
    }

    public function update(Request $request, Product $product)
    {
        // リクエストされた情報を確認して、必要な情報が全て揃っているかチェックします。
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);
        //バリデーションによりフォームに未入力項目があればエラーメッセー発生させる（未入力です　など）

        // 商品の情報を更新します。
        $product->product_name = $request->product_name;
        //productモデルのproduct_nameをフォームから送られたproduct_nameの値に書き換える
        $product->price = $request->price;
        $product->stock = $request->stock;

        // 更新した商品を保存します。
        $product->save();
        // モデルインスタンスである$productに対して行われた変更をデータベースに保存するためのメソッド（機能）です。

        // 全ての処理が終わったら、商品一覧画面に戻ります。
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
        // ビュー画面にメッセージを代入した変数(success)を送ります
    }

    public function destroy(Product $product)
//(Product $product) 指定されたIDで商品をデータベースから自動的に検索し、その結果を $product に割り当てます。
    {
        // 商品を削除します。
        $product->delete();

        // 全ての処理が終わったら、商品一覧画面に戻ります。
        return redirect('/products');
        //URLの/productsを検索します
        //products　/がなくても検索できます
    }

    
}

