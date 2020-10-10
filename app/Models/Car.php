<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'name',
        'price',
        'condition',
        'year',
        'color',
        'speed',
        'shop_id',
        'category_id',
        'brand_id',
    ];

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function brand(){
        return $this->belongsTo('App\Models\Brand');
    }
}
