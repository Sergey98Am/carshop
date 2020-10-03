<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Stripe;
use JWTAuth;



class CheckoutController extends Controller
{
    public function store(Request $request, $id)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $stripe = Stripe\Charge::create([
                "amount" => 100 * 150,
                "currency" => $request->currency,
                "source"  => $request>stripeToken,
            ]);


            return response()->json(['stripe' => $stripe]);
        } catch (Stripe\Exception\ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
