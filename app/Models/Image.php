<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Image extends Model
{
    use HasFactory;

    public function Add($data)
    {
        return DB::table('image')
                    ->insertGetId($data);
    }

    public function ProductImages($data)
    {
        return DB::table('product_image')
                    ->insert($data);
    }
}
