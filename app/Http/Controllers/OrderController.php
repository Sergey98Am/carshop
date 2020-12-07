<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use JWTAuth;
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
            $pendingOrders = Order::OrderBy('id', 'desc')->where('user_id', JWTAuth::user()->id)->where('status_id', 1)->get();
            $canceledOrders = Order::OrderBy('id', 'desc')->where('user_id', JWTAuth::user()->id)->where('status_id', 2)->get();
            $purchasedOrders = Order::OrderBy('id', 'desc')->where('user_id', JWTAuth::user()->id)->where('status_id', 3)->get();

            return response()->json([
                'pendingOrders' => $pendingOrders,
                'canceledOrders' => $canceledOrders,
                'purchasedOrders' => $purchasedOrders
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function add(OrderRequest $request)
    {
        try {
            $orders = Order::where('user_id', JWTAuth::user()->id)->where('status_id', 1)->get();
            $a = true;

            foreach ($orders as $order) {
                if ($order->car_id == $request->car_id) {
                    $request->quantity = $order->quantity + $request->quantity;
                    $order->update([
                        'quantity' => $request->quantity,
                        'total_price' => $request->item_price * $request->quantity,
                    ]);
                    $a = false;
                    return response()->json([
                        'message' => 'Order successfully updated'
                    ], 200);

                }
            }

            if ($a) {
                $order = Order::create([
                    'quantity' => $request->quantity,
                    'item_price' => $request->item_price,
                    'total_price' => $request->item_price * $request->quantity,
                    'car_id' => $request->car_id,
                    'user_id' => JWTAuth::user()->id
                ]);

                if ($order) {
                    return response()->json([
                        'message' => 'Order successfully created'
                    ], 200);
                } else {
                    throw new \Exception('Something went wrong');
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
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
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function cancelOrder($id)
    {
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
