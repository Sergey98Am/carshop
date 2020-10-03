<?php

namespace App\Http\Controllers\AdminPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use JWTAuth;
use Validator;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cars = Car::all();
        return response()->json([
            'cars' => $cars
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
        $validator = Validator::make($request->all(), [
           'name' => 'required|min:2|max:255|unique:cars,name',
           'price' => 'required',
           'condition' => 'required',
           'year' => 'required',
           'color' => 'required',
           'speed' => 'required',
           'category_id' => 'exists:categories,id',
           'brand_id' => 'exists:brands,id'
       ]);
       if ($validator->fails()) {
           return response()->json([
               'error' => $validator->errors()->toJson()
           ], 400);
       }

        Car::create([
            'name' => $request->name,
            'price' => $request->price,
            'condition' => $request->condition,
            'year' => $request->year,
            'color' => $request->color,
            'speed' => $request->speed,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id
        ]);

       return response()->json([
           'message' => 'Car successfully created'
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255|unique:cars,name,'.$id,
            'price' => 'required',
            'condition' => 'required',
            'year' => 'required',
            'color' => 'required',
            'speed' => 'required',
            'category_id' => 'exists:categories,id',
            'brand_id' => 'exists:brands,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toJson()
            ], 400);
        }

        $car = Car::find($id);
        if ($car) {
            $car->create([
                'name' => $request->name,
                'price' => $request->price,
                'condition' => $request->condition,
                'year' => $request->year,
                'color' => $request->color,
                'speed' => $request->speed,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id
            ]);
        } else {
            return response()->json([
                'error' => 'car does not exist'
            ], 400);
        }

        return response()->json([
            'message' => 'Car successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

    // TODO: Create request file
    public function destroy($id)
    {
        $destroy = Car::find($id);
        if ($destroy) {
            return response()->json([
                'message' => 'Car successfully deleted'
            ],200);


        } else {
            return response()->json([
                'error' => 'car does not exist'
            ], 400);
        }
    }


    public function uploadImage(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,jpg,png,gif'
        ]);

       if ($validator->fails()) {
           return response()->json([
               'error' => $validator->errors()->toJson()
           ], 400);
       }
            $car = Car::find($id);
            $file = $request->file('image');
            $file_name = time().$file->getClientOriginalName();
            $file->move(public_path().'/images/',$file_name);
            $car->image = $file_name;
            $car->save();
            return response()->json([
                'message' => 'Image successfully created'
            ]);
    }
}
