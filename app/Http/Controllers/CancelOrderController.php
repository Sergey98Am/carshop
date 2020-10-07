<?php

namespace App\Http\Controllers;

use App\Models\Order;

class CancelOrderController extends Controller
{
    public function cancelOrder($id){
        $order = Order::find($id);

        if ($order) {
            $order->update([
               'status_id' => '2'
            ]);

            return response()->json([
                'message' => 'Order canceled',
            ], 200);
        } else {
            return response()->json([
                'error' => 'Order does not exist',
            ], 400);
        }
    }
}
