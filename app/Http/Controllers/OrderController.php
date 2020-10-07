<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = Order::OrderBy('id','desc')->get();

        return response()->json([
            'orders' => $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrderCreateRequest $request)
    {
        $order = Order::create([
            'quantity' => $request->quantity,
            'item_price' => $request->item_price,
            'car_id' => $request->car_id,
            'user_id' => $request->user_id
        ]);

        if ($order) {
            return response()->json([
                'message' => 'Order successfully created'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Something went wrong'
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(OrderUpdateRequest $request, $id)
    {
        $order = Order::find($id);

        if ($order) {
            $order->update([
                'quantity' => $request->quantity,
                'item_price' => $request->item_price,
            ]);
            return response()->json([
                'message' => 'Order successfully updated'
            ]);
        } else {
            return response()->json([
                'error' => 'Order does not exist'
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $destroy = Order::find($id);
        if ($destroy) {
            $destroy->delete();
            return response()->json([
                'message' => 'Order successfully deleted'
            ],200);

        } else {
            return response()->json([
                'error' => 'Order does not exist'
            ], 400);
        }
    }
}
