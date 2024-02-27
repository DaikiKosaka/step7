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

}
