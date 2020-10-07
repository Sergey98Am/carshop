<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Stripe;
use App\Models\Order;
use JWTAuth;

class CheckoutController extends Controller
{    public function checkout(TransactionRequest $request, $id)
    {
        $order = Order::find($id);

        if ($order) {
            try {
                $stripe = new \Stripe\StripeClient(
                    config('services.stripe.secret')
                );

                $token = $stripe->tokens->create([
                    'card' => [
                        'number' => $request->number,
                        'exp_month' => $request->exp_month,
                        'exp_year' => $request->exp_year,
                        'cvc' => $request->cvc,
                        'address_country' => $request->country,
                        'address_city' => $request->city,
                    ],
                ]);

                $customer = $stripe->customers->create([
                    'phone' => $request->phone,
                    'source' => $token->id
                ]);

                $charge = $stripe->charges->create([
                    'customer' => $customer->id,
                    'amount' => ($order->item_price * 100) * $order->quantity,
                    'currency' => $request->currency,
                ]);

                //Create transaction
                $transaction = Transaction::create([
                    'transaction_id' => $charge->id,
                    'country' => $request->country,
                    'city' => $request->city,
                    'phone' => $request->phone,
                    'amount' => $order->item_price * $order->quantity,
                    'currency' => $request->currency,
                    'status' => 'Purchased',
                    'order_id' => $order->id,
                    'user_id' => JWTAuth::user()->id
                ]);

                if ($transaction) {
                    $order->update([
                       'status_id' => 3
                    ]);

                    return response()->json([
                        'message' => 'Transaction successfully created',
                        'charge' => $charge,
                        'customer' => $customer
                    ], 200);
                } else {
                    return response()->json([
                        'error' => 'Something went wrong'
                    ], 400);
                }
            } catch (Stripe\Exception\ApiErrorException $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        } else {
            return response()->json([
                'error' => 'Order does not exists'
            ], 400);
        }
    }
}
