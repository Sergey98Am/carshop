<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use JWTAuth;
use Validator;

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

    // TODO: Create request file
    public function store(Request $request)
    {
        $input = $request->except('_token');

        $validator = Validator::make($request->all(), [
            'item_price' => 'required',
            'status_id' => 'exists:statuses,id',
            'car_id' => 'exists:cars,id',
            'user_id' => 'exists:users,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toJson()
            ], 400);
        }

        Order::create([
            'quantity' => $request->quantity,
            'item_price' => $request->item_price,
            'car_id' => $request->car_id,
            'user_id' => $request->user_id
        ]);

        return response()->json([
            'message' => 'Order successfully created'
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

    // TODO: Create request file
    public function update(Request $request, $id)
    {
        $input = $request->except('_token','_method','id');

        $validator = Validator::make($request->all(), [
            'item_price' => 'required',
            'status_id' => 'exists:statuses,id',
            'car_id' => 'exists:cars,id',
            'user_id' => 'exists:users,id'
        ]);
        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()->toJson()
            ], 400);
        }

        $order = Order::find($id);
        if ($order) {
            $order->create([
                'quantity' => $request->quantity,
                'item_price' => $request->item_price,
                'status_id' => $request->status_id,
                'car_id' => $request->car_id,
                'user_id' => $request->user_id
            ]);
        } else {
            return response()->json([
                'error' => 'brand does not exist'
            ], 400);
        }

        return response()->json([
            'message' => 'Order successfully updated'
        ]);
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
            return response()->json([
                'message' => 'Order successfully deleted'
            ],200);

            $destroy->delete();
        } else {
            return response()->json([
                'error' => 'Order does not exist'
            ], 400);
        }

        return response()->json([
            'message' => 'Order successfully deleted'
        ]);
    }
}
