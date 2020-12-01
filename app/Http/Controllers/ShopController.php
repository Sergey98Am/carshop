<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShopCreateRequest;
use App\Http\Requests\ShopUpdateRequest;
use App\Models\User;
use App\Models\Shop;
use JWTAuth;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            if ($request->path() == 'api/shop-owner/shops') {
                $shops = User::with([
                    'shops' => function ($q) {
                        $q->orderBy('id', 'desc');
                    }
                ])->find(JWTAuth::user()->id);

                return response()->json([
                    'shops' => $shops->shops
                ]);
            } else {
                $shops = Shop::orderBy('id', 'desc')->get();

                return response()->json([
                    'shops' => $shops
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ShopCreateRequest $request)
    {
        try {
            $shop = Shop::create([
                'name' => $request->name,
                'user_id' => JWTAuth::user()->id
            ]);

            if ($shop) {
                return response()->json([
                    'shop' => $shop,
                    'message' => 'Shop successfully created'
                ], 200);
            } else {
                throw new \Exception('Something went wrong');
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        try {
            $shop = Shop::find($id);

            if ($shop) {
                return response()->json([
                    'shop' => $shop
                ], 200);
            } else {
                throw new \Exception('Shop does not exist');
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Shop $shop
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ShopUpdateRequest $request, $id)
    {
        try {
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
                throw new \Exception('Shop does not exist');
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
     * @param \App\Shop $shop
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $shop = Shop::find($id);

            if ($shop) {
                $shop->delete();
                return response()->json([
                    'message' => 'Shop successfully deleted'
                ], 200);
            } else {
                throw new \Exception('Shop does not exist');
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
