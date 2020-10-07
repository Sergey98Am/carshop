<?php

namespace App\Http\Controllers\ShopOwnerPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopCreateRequest;
use App\Http\Requests\ShopUpdateRequest;
use App\Models\Shop;
use JWTAuth;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $shops = Shop::OrderBy('id','desc')->get();

        return response()->json([
            'shops' => $shops
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ShopCreateRequest $request)
    {
        $shop = Shop::create([
            'name' => $request->name,
            'user_id' => JWTAuth::user()->id
        ]);

        if ($shop) {
            return response()->json([
                'message' => 'Shop successfully created'
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
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ShopUpdateRequest $request, $id)
    {
        $shop = Shop::find($id);

        if ($shop) {
            $shop->update([
                'name' => $request->name,
                'user_id' => JWTAuth::user()->id
            ]);
            return response()->json([
                'message' => 'Shop successfully updated'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Shop does not exist'
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $destroy = Shop::find($id);

        if ($destroy) {
            $destroy->delete();
            return response()->json([
                'message' => 'Shop successfully deleted'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Shop does not exist'
            ], 400);
        }
    }
}
