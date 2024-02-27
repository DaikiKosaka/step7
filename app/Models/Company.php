<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // 修正：belongsToの関連先はProductモデルであるべきです。
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
