<?php

namespace App\Http\Controllers;
use Stripe;
use JWTAuth;



class CheckoutController extends Controller
{
    public function store()
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $stripe = Stripe\Charge::create([
                "amount" => 100 * 150,
                "currency" => "usd",
                "description" => "Making test payment.",
                "source"  => "tok_visa",
            ]);

            return response()->json(['stripe' => $stripe]);
        } catch (Stripe\Exception\ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
