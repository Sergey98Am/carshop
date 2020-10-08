<?php

namespace App\Http\Controllers\ShopOwnerPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarImageUploadRequest;
use App\Http\Requests\CarCreateRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Models\Shop;
use App\Models\Car;
use JWTAuth;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $cars = Car::OrderBy('id', 'desc')->get();

            return response()->json([
                'cars' => $cars
            ], 200);
        }  catch(\Exception $e) {
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

    public function store(CarCreateRequest $request)
    {
        try {
            $car = Car::create([
                'name' => $request->name,
                'price' => $request->price,
                'condition' => $request->condition,
                'year' => $request->year,
                'color' => $request->color,
                'speed' => $request->speed,
                'shop_id' => $request->shop_id,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
            ]);

            if ($car) {
                return response()->json([
                    'message' => 'Car successfully created'
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

    public function update(CarUpdateRequest $request, $id)
    {
        try {
            $car = Car::find($id);
            if ($car) {
                $car->update([
                    'name' => $request->name,
                    'price' => $request->price,
                    'condition' => $request->condition,
                    'year' => $request->year,
                    'color' => $request->color,
                    'speed' => $request->speed,
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                ]);
                return response()->json([
                    'message' => 'Car successfully updated'
                ], 200);
            } else {
                throw new \Exception('Cars does not exist');
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
            $car = Car::find($id);
            if ($car) {
                $car->delete();
                return response()->json([
                    'message' => 'Car successfully deleted'
                ], 200);

            } else {
                throw new \Exception('Cars does not exist');
            }
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function uploadImage(CarImageUploadRequest $request, $id)
    {
        try {
            $car = Car::find($id);
            if ($car) {
                $file = $request->file('image');
                $file_name = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/images/', $file_name);
                $car->image = $file_name;

                $car->update([
                    'image' => $file_name
                ]);
                return response()->json([
                    'message' => 'Image successfully uploaded'
                ]);
            } else {
                throw new \Exception('Cars does not exist');
            }
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function carsShop($id)
    {
        try {
            $shop = Shop::with('cars')->find($id);

            if ($shop) {
                return response()->json([
                    'cars' => $shop->cars
                ], 200);
            } else {
                throw new \Exception('Cars does not exist');
            }
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
