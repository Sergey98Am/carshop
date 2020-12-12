<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CarCreateRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Models\Category;
use App\Models\Brand;
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
    public function index(Request $request)
    {
        try {
            $categories = Category::all();
            $brands = Brand::all();
            $shops = Shop::where('user_id', JWTAuth::user()->id)->get();
            if ($request->path() == 'api/shop-owner/cars') {
                $cars = Car::with('shop')->whereHas(
                    'shop', function ($q) {
                    return $q->where('user_id', JWTAuth::user()->id);
                }
                )->with('shop', 'category', 'brand')->orderBy('id', 'desc')->get();

                return response()->json([
                    'categories' => $categories,
                    'brands' => $brands,
                    'shops' => $shops,
                    'cars' => $cars
                ], 200);
            } else {
                $cars = Car::with('shop')->orderBy('id', 'desc')
                    ->with('shop', 'category', 'brand')->get();

                return response()->json([
                    'cars' => $cars
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function recommendedCars()
    {
        try {
            $recommendedCars = Car::inRandomOrder()->limit(10)->get();

            return response()->json([
                'recommendedCars' => $recommendedCars
            ], 200);

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

    public function store(CarCreateRequest $request)
    {
        try {
            $file = $request->file('image');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . '/images/', $file_name);

            $car = Car::create([
                'image' => $file_name,
                'name' => $request->name,
                'price' => $request->price,
                'condition' => $request->condition,
                'year' => $request->year,
                'color' => $request->color,
                'speed' => $request->speed,
                'quantity' => $request->quantity,
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(CarUpdateRequest $request, $id)
    {
        try {
            $car = Car::find($id);
            if ($car) {

                if ($request->hasFile('image')) {
                    \File::delete(public_path() . '/images/' . $car->image);
                    $file = $request->file('image');
                    $file_name = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path() . '/images/', $file_name);
                    $car->image = $file_name;
                }

                $car->update([
                    'name' => $request->name,
                    'price' => $request->price,
                    'condition' => $request->condition,
                    'year' => $request->year,
                    'color' => $request->color,
                    'speed' => $request->speed,
                    'quantity' => $request->quantity,
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                ]);
                return response()->json([
                    'message' => 'Car successfully updated'
                ], 200);
            } else {
                throw new \Exception('Cars does not exist');
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
            $car = Car::find($id);
            if ($car) {
                \File::delete(public_path() . '/images/' . $car->image);
                $car->delete();
                return response()->json([
                    'message' => 'Car successfully deleted'
                ], 200);

            } else {
                throw new \Exception('Cars does not exist');
            }
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function search(Request $request)
    {
        try {
            $cars = Car::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('price', 'LIKE', '%' . $request->search . '%')
                ->orWhere('condition', 'LIKE', '%' . $request->search . '%')
                ->orWhere('year', 'LIKE', '%' . $request->search . '%')
                ->orWhere('color', 'LIKE', '%' . $request->search . '%')
                ->orWhere('speed', 'LIKE', '%' . $request->search . '%')
                ->get();

            return response()->json([
                'cars' => $cars
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
