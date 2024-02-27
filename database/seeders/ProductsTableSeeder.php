<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
public function run()
{
    Product::factory()->count(10)->create();
}
    
}