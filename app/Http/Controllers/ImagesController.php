<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function __construct()
    {
        $this->MdlProduct = new Product();
        $this->MdlImages = new Image();
    }

    public function ProductUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'=>'required|numeric',
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->responseFailed('','failed');
        }

        $UploadFolder = 'product';
        $Image = $request->file('image');
        $ImageUploadedPath = $Image->store($UploadFolder, 'public');
        $DataIage = [
            'name'=> basename($ImageUploadedPath),
            'file'=> $ImageUploadedPath,
            'enabel'=>1
        ];
        $AddImageDb = $this->MdlImages->Add($DataIage);
        if(is_int($AddImageDb)){
            $ProductImagesData =[
                'product_id'=> $request->input('product_id'),
                'image_id'=> $AddImageDb
            ];
            $AddImageProduct = $this->MdlImages->ProductImages($ProductImagesData);

            if($AddImageProduct){
                $uploadedImageResponse = array(
                    "image_name" => basename($ImageUploadedPath),
                    "image_url" => Storage::disk('public')->url($ImageUploadedPath),
                    "mime" => $Image->getClientMimeType()
                );
                return $this->responseSuccess($uploadedImageResponse,'success');
            }else{
                return $this->responseFailed('Gagal menyimpan image dalam product','failed');
            }
        }else{
            return $this->responseFailed('Gambar tidak dapat di simpan','failed');
        }
    }

    public function AddImageOnProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'=>'required|numeric',
            'image_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return $this->responseFailed('','failed');
        }
        $DataDonotExist = $this->MdlImages->ProductImageDonotExist($request->input('product_id'),$request->input('image_id'));
        if($DataDonotExist){
            $ProductImagesData =[
                'product_id'=> $request->input('product_id'),
                'image_id'=> $request->input('image_id')
            ];
            $AddImageProduct = $this->MdlImages->ProductImages($ProductImagesData);
            if($AddImageProduct){
                return $this->responseSuccess('','Image berhasil tersimpan dalam product');
            }else{
                return $this->responseFailed('','failed');
            }
        }else{
            return $this->responseSuccess('','Image sudah tersimpan dalam product');
        }
    }

    public function RemoveImageOnProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'=>'required|numeric',
            'image_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return $this->responseFailed('','failed');
        }
        $DataDonotExist = $this->MdlImages->ProductImageExist($request->input('product_id'),$request->input('image_id'));
        if($DataDonotExist){
            $ImageProductRemove = $this->MdlImages->DeletedProductCategoryExist($request->input('product_id'),$request->input('image_id'));
            return $this->responseSuccess('','Image berhasil terhapus dalam product');
        }else{
            return $this->responseSuccess('','Image sudah terhapus dalam product');
        }
    }
}
