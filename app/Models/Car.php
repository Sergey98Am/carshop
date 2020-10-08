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
        'user_id'
    ];

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }
}
