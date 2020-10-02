<?php

namespace App\Http\Controllers\AdminPage;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $brands = Brand::OrderBy('id','desc')->get();

        return response()->json([
            'brands' => $brands
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    // TODO: create request file
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'name' => 'required|min:2|max:255|unique:brands,name'
       ]);
       if ($validator->fails()) {
           return response()->json([
               'error' => $validator->errors()->toJson()
           ], 400);
       }

       Brand::create([
           'name' => $request->name
       ]);

       return response()->json([
           'message' => 'Brand successfully created'
       ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255|unique:brands,name,'.$id
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toJson()
            ], 400);
        }

        $brand = Brand::find($id);

        if ($brand) {
            $brand->create([
                'name' => $request->name
            ]);
        } else {
            return response()->json([
                'error' => 'brand does not exist'
            ], 400);
        }


        return response()->json([
            'message' => 'Brand successfully updated'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $destroy = Brand::find($id);
        if ($destroy) {
            return response()->json([
                'message' => 'Brand successfully deleted'
            ],200);

            $destroy->delete();
        } else {
            return response()->json([
                'error' => 'brand does not exist'
            ], 400);
        }
    }
}
