<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the sales.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Sales モデルを使用してすべての売上データを取得
            $sales = Sales::all();

            // 取得したデータを 'sales' ビューに渡して表示
            return view('sales.index', ['sales' => $sales]);
        } catch (\Exception $e) {
            // エラーハンドリング: データ取得に失敗した場合はエラーメッセージを表示
            return back()->withError('Failed to fetch sales data.')->withInput();
        }
    }
}
