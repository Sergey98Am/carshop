<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'id',
        'quantity',
        'item_price',
        'total_price',
        'status_id',
        'car_id',
        'user_id'
    ];

    public function transaction(){
        return $this->hasOne('App\Models\Transaction');
    }

    public function status(){
        return $this->hasOne('App\Models\Status');
    }
}
