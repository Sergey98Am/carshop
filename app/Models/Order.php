<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['quantity','item_price','status_id','car_id','user_id'];

    public function transactions(){
        return $this->hasMany('App\Models\Transaction');
    }

    public function status(){
        return $this->hasOne('App\Models\Status');
    }
}
