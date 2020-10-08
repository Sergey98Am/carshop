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
        try {
            $orders = Order::OrderBy('id', 'desc')->get();

            return response()->json([
                'orders' => $orders
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrderCreateRequest $request)
    {
        try {
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
                throw new \Exception('Something went wrong');
            }
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
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
        try {
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
                throw new \Exception('Order does not exist');
            }
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
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
        try {
            $order = Order::find($id);

            if ($order) {
                $order->delete();
                return response()->json([
                    'message' => 'Order successfully deleted'
                ], 200);

            } else {
                throw new \Exception('Order does not exist');
            }
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function cancelOrder($id){
        try {
            $order = Order::find($id);

            if ($order) {
                $order->update([
                    'status_id' => '2'
                ]);

                return response()->json([
                    'message' => 'Order canceled',
                ], 200);
            } else {
                throw new \Exception('Order does not exist');
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
