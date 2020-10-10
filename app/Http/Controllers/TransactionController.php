<?php

namespace App\Http\Controllers;
use App\Http\Requests\TransactionRequest;
use Stripe;
use App\Models\Transaction;
use App\Models\Order;
use JWTAuth;

class TransactionController extends Controller
{
    public function checkout(TransactionRequest $request, $id)
    {
        try {
            $order = Order::find($id);

            if ($order) {
                $stripe = new \Stripe\StripeClient(
                    config('services.stripe.secret')
                );

                $token = $stripe->tokens->create([
                    'card' => [
                        'name' => $request->name,
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
                    'user_id' => JWTAuth::user()->id,
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
                    throw new \Exception('Something went wrong');
                }
            } else {
                throw new \Exception('Order does not exist');
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function cancelTransaction($id)
    {
        try {
            $order = Order::with('transaction')->find($id);

            if ($order && $order->transaction) {
                $stripe = new \Stripe\StripeClient(
                    config('services.stripe.secret')
                );

                $cancel = $stripe->refunds->create([
                    'charge' => $order->transaction->transaction_id,
                ]);

                $order->update([
                    'status_id' => 2
                ]);

                $order->transaction->update([
                    'status' => 'Canceled'
                ]);

                return response()->json([
                    'cancel' => $cancel,
                ], 200);
            } else {
                throw new \Exception('Order does not exist');
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
