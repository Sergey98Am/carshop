<?php

namespace App\Http\Controllers;
use App\Models\Country;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{

    public function index()
    {
        // return 12312;
        $user =  Auth::user();
        Log::info('message::' . json_encode("user"));
        return response()->json(['user' => $user]);
    }
}
