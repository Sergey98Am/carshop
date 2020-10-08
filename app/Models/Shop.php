<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'name',
        'user_id'
    ];

    public function cars(){
        return $this->hasMany('App\Models\Car');
    }
}
