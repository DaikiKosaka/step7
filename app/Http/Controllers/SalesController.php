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
            $sales = Sales::all();

            return view('sales.index', ['sales' => $sales]);
        } catch (\Exception $e) {

            return back()->withError('Failed to fetch sales data.')->withInput();
        }
    }
}
