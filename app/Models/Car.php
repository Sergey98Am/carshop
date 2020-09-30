<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['image','name','price','condition','quantity','year','color','speed','category_id','brand_id'];

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }
}
