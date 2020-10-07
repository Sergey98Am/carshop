<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_id',
        'country',
        'city',
        'phone',
        'amount',
        'currency',
        'status',
        'order_id',
        'user_id'
    ];
}
