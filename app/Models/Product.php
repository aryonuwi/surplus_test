<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    public function Add($data)
    {
        return DB::table('product')
                    ->insertGetId($data);
    }

    public function AddCategoryToProduct($data)
    {
        return DB::table('category_product')
                    ->insert($data);
    }

}
