@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
       <div class="card"style="bs-btn-padding-y: 25rem; --bs-btn-font-size: .75rem;">
       <div class="card-header"><h2>商品情報詳細画面</h2></div>

    
        <h2>ID</h2>
        <h3 class="mb-3">{{ $product->id }}</h3>

        <h2>商品画像</h2>
        <img src="{{ asset($product->img_path) }}" alt="画像" class="product-image">

        <h2>商品名</h2>
        <h3 class="mb-3">{{$product->product_name}}</h3>

        <h2>メーカー</h2>
        <h3 class="mb-3">{{ $product->company_name }}</h3>

        <h2>価格</h2>
        <h3 class="mb-3">{{ $product->price }}</h3>

        <h2>在庫数</h2>
        <h3 class="mb-3">{{ $product->stock }}</h3>

        <h2>コメント</h2>
        <h3 class="mb-3">{{ $product->comment }}</h3>

        </div>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">戻る</a>

    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-lg">編集</a>
</div>


    

@endsection

