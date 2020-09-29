<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['image','name','price','total_price','condition','quantity','year','color','speed','car_id','user_id'];

    public function transactions(){
        return $this->hasMany('App\Models\Transaction');
    }

    public function statuses(){
        return $this->belongsToMany('App\Models\Status');
    }
}
