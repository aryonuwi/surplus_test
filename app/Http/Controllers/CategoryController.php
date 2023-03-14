<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;



class CategoryController extends Controller
{
    public function __construct(){
        $this->MdlCategory = new Category();
    }

    public function List(Request $request){
        $category_list = $this->MdlCategory->GetAll();
        return $this->responseSuccess($category_list,'Berikut list category');
    }

    public function Singel($id,Request $request){

    }

    public function Created(Request $request)
    {

    }

    public function Updated($id, Request $request)
    {

    }

    public function Deleted($id, Request $request)
    {

    }
}
