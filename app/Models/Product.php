<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    public function GetAll()
    {
        return DB::table('product')
                    ->select('id','name','Description')
                    ->where('enabel',1)
                    ->get()
                    ->all();
    }

    public function GetProduct($id)
    {
        return DB::table('product')
                    ->select('id','name','Description')
                    ->where('id',$id)
                    ->where('enabel',1)
                    ->get()
                    ->first();

    }

    public function GetCategoryIdInProductCategoryExist($product_id)
    {
        return DB::table('category_product')
                ->select('category_id')
                ->where('product_id',$product_id)
                ->get()
                ->all();
    }

    public function DeletedProductCategoryExist($product_id, $category_id)
    {
        DB::table('category_product')->where('product_id', $product_id)->where('category_id', $category_id)->delete();
    }

    public function GetProductRelatedToCategory($product_id)
    {
        return DB::table('category_product')
                    ->join('category','category_product.category_id','=','category.id')
                    ->select(
                        'category.id',
                        'category.name'
                    )
                    ->where('category_product.product_id',$product_id)
                    ->get()
                    ->all();
    }

    public function AddCategoryToProduct($data)
    {
        return DB::table('category_product')
                    ->insert($data);
    }

    public function UpdatedData($id,$data)
    {
        return DB::table('product')
                    ->where('id', $id)
                    ->update($data);
    }

}
