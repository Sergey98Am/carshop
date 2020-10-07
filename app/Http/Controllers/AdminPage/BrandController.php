<?php

namespace App\Http\Controllers\AdminPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandCreateRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;

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
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(BrandCreateRequest $request)
    {
       $brand = Brand::create([
           'name' => $request->name
       ]);

       if ($brand) {
           return response()->json([
               'message' => 'Brand successfully created'
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
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BrandUpdateRequest $request, $id)
    {
        $brand = Brand::find($id);

        if ($brand) {
            $brand->update([
                'name' => $request->name
            ]);
            return response()->json([
                'message' => 'Brand successfully updated'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Brand does not exist'
            ], 400);
        }
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
            $destroy->delete();
            return response()->json([
                'message' => 'Brand successfully deleted'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Brand does not exist'
            ], 400);
        }
    }
}
