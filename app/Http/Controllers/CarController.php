<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;

class CarController extends Controller
{
    public function index(){
        return response()->json(['cars' => []]);
    }
}
