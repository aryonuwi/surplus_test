<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->MdlCategory = new Category();
        $this->MdlProduct = new Product();
    }

    public function List(Request $request)
    {
        $product_list = $this->MdlProduct->GetAll();
        return $this->responseSuccess($product_list ,'Berikut list category');
    }

    public function Singel($id,Request $request)
    {
        $product = $this->MdlProduct->GetProduct($id);
        $product->category = $this->MdlProduct->GetProductRelatedToCategory($id);
        return $this->responseSuccess($product,'Berikut list category');
    }

    public function Created(Request $request)
    {
        $validate = Validator::make($request->all(),[
            "name"=>"required",
            "description"=>"required",
            "category_id"=>"required|array"
        ]);
        if ($validate->fails()) {
           return $this->responseFailed($validate->errors()->all());
        }
        $data = [
            'name' => $request->input('name'),
            'description'=>$request->input('description'),
            'enabel' => 1,
        ];

        $ins_product = $this->MdlProduct->add($data);
        if(is_int($ins_product)){
            $relation_data = [];
            foreach($request->category_id as $index => $category_id){
                $relation_data[$index]['category_id'] = $category_id;
                $relation_data[$index]['product_id'] = $ins_product;
            }
            $relation_insert = $this->MdlProduct->AddCategoryToProduct($relation_data);

            if($relation_insert){
                return $this->responseSuccess(['Id'=>$ins_product,'name'=>$data['name']],'Success Created Category','created');
            }else{
                return $this->responseFailed(['Failed related with category']);
            }
        }else{
            return $this->responseFailed(['Created failed']);
        }
    }

    public function Updated($id,Request $request)
    {
        $validate = Validator::make($request->all(),[
            "name"=>"required",
            "description"=>"required",
            "category_id"=>"required|array"
        ]);

        if(!is_numeric($id)){
            return $this->responseFailed(['Id is failed']);
        }

        if ($validate->fails()) {
           return $this->responseFailed($validate->errors()->all());
        }

        $data = [
            'name' => $request->input('name'),
            'description'=>$request->input('description')
        ];

        $updated_product = $this->MdlProduct->UpdatedData($id, $data);

        if(is_int($updated_product)){
            // $relation_data = [];
            // foreach($request->category_id as $index => $category_id){
            //     $relation_data[$index]['category_id'] = $category_id;
            //     $relation_data[$index]['product_id'] = $ins_product;
            // }
            // $relation_insert = $this->MdlProduct->AddCategoryToProduct($relation_data);

            // if($relation_insert){
            return $this->responseSuccess(['Id'=>$id,'name'=>$data['name']],'Success updated ','update');
            // return $this->responseSuccess(['Id'=>$ins_product,'name'=>$data['name']],'Success Created Category','created');
            // }else{
            //     return $this->responseFailed(['Failed related with category']);
            // }
        }else{
            return $this->responseFailed(['Created failed']);
        }
    }

    public function Deleted($id, Request $request)
    {
        $category = $this->MdlProduct->GetProduct($id);;

        if(empty($category)){
            return $this->responseFailed([],'notfound');
        }

        $data = [
            'enabel'=>'0'
        ];

        $respons = $this->MdlProduct->UpdatedData($id, $data);

        if($respons){
            return $this->responseSuccess(['Id'=>$id,'name'=>$category->name],'Success Deleted ','deleted');
        }else{
            return $this->responseFailed(['deleted failed']);
        }
    }

}
