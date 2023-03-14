<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct(){
        $this->MdlCategory = new Category();
    }

    public function List(Request $request){
        $category_list = $this->MdlCategory->GetAll();
        return $this->responseSuccess($category_list,'Berikut list category');
    }

    public function Singel($id, Request $request){
        if(!is_int($id)){
            return $this->responseFailed([''],'Periksa kembali data yang anda input');
        }
        $category = $this->MdlCategory->GetCategory($id);
        if(!empty($category)){
            return $this->responseSuccess($category);
        }else{
            return $this->responseFailed(['Data tidak dapat di temukan'],'notfound');
        }
    }

    public function Created(Request $request)
    {
        $validate = Validator::make($request->all(),[
            "name"=>"required"
        ]);

        if ($validate->fails()) {
           return $this->responseFailed($validate->errors()->all());
        }
        $data = [
            'name' => $request->input('name'),
            'enabel' => 1,
        ];

        $respons =  $this->MdlCategory->add($data);

        if(is_int($respons)){
            return $this->responseSuccess(['Id'=>$respons,'name'=>$data['name']],'Success Created Category','created');
        }else{
            return $this->responseFailed(['Created failed']);
        }
    }

    public function Updated($id, Request $request)
    {
        $validate = Validator::make($request->all(),[
            "name"=>"required"
        ]);

        if(!is_numeric($id)){
            return $this->responseFailed(['Id is failed']);
        }

        if ($validate->fails()) {
           return $this->responseFailed($validate->errors()->all());
        }

        $data = [
            'name'=>$request->input('name')
        ];
        $respons = $this->MdlCategory->UpdateData($id,$data);

        if(is_int($respons)){
            return $this->responseSuccess(['Id'=>$respons,'name'=>$data['name']],'Success updated ','update');
        }else{
            return $this->responseFailed(['updated failed']);
        }
    }

    public function Deleted($id, Request $request)
    {
        $category = $this->MdlCategory->GetCategory($id);;

        if(empty($category)){
            return $this->responseFailed([],'notfound');
        }

        $data = [
            'enabel'=>'0'
        ];

        $respons = $this->MdlCategory->UpdateData($id,$data);

        if($respons){
            return $this->responseSuccess(['Id'=>$id,'name'=>$category->name],'Success Deleted ','deleted');
        }else{
            return $this->responseFailed(['deleted failed']);
        }
    }
}
