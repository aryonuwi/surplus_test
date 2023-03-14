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

    public function add($data)
    {
        return DB::table('category')
                    ->insertGetId($data);
    }
}
