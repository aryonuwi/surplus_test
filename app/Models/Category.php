<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    public function GetAll()
    {
        return DB::table('category')
                    ->select('id','name')
                    ->where('enabel',1)
                    ->get()
                    ->all();
    }

    public function GetCategory($id)
    {
        return DB::table('category')
        ->select('id','name')
        ->where('id',$id)
        ->where('enabel',1)
        ->get()
        ->first();
    }

    public function Add($data)
    {
        return DB::table('category')
                    ->insertGetId($data);
    }

    public function UpdateData($id, $data)
    {
        return DB::table('category')
                    ->where('id', $id)
                    ->update($data);
    }

}
