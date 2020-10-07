<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelTransactionRequest;
use Stripe;
use App\Models\Order;

class CancelTransactionController extends Controller
{
    public function cancelTransaction(CancelTransactionRequest $request, $id){
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
                return response()->json([
                    'error' => 'Order does not exists'
                ], 400);
            }
        } catch (Stripe\Exception\ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
