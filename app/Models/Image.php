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

    public function ProductImageDonotExist($product_id,$image_id)
    {
        return DB::table('product_image')
                    ->where('product_id',$product_id)
                    ->where('image_id',$image_id)
                    ->doesntExist();
    }

    public function ProductImageExist($product_id,$image_id)
    {
        return DB::table('product_image')
                    ->where('product_id',$product_id)
                    ->where('image_id',$image_id)
                    ->exists();
    }

    public function DeletedProductCategoryExist($product_id, $image_id)
    {
        DB::table('product_image')->where('product_id', $product_id)->where('image_id', $image_id)->delete();
    }


    public function GetProductRelatedToImage($product_id)
    {
        return DB::table('product_image')
                    ->join('image','product_image.image_id','=','image.id')
                    ->select(
                        'image.id',
                        'image.name',
                        'image.file'
                    )
                    ->where('product_image.product_id',$product_id)
                    ->get()
                    ->all();
    }

}
