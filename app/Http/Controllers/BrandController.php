<?php

namespace App\Http\Controllers;

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
        try {
            $brands = Brand::OrderBy('id', 'desc')->get();

            return response()->json([
                'brands' => $brands
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function limitedBrands() {
        try {
            $limitedBrands = Brand::OrderBy('id', 'desc')->limit(10)->get();

            return response()->json([
                'limitedBrands' => $limitedBrands
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

    public function store(BrandCreateRequest $request)
    {
        try {
            $brand = Brand::create([
                'name' => $request->name
            ]);

            if ($brand) {
                return response()->json([
                    'message' => 'Brand successfully created'
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
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BrandUpdateRequest $request, $id)
    {
        try {
            $brand = Brand::find($id);

            if ($brand) {
                $brand->update([
                    'name' => $request->name
                ]);
                return response()->json([
                    'message' => 'Brand successfully updated'
                ], 200);
            } else {
                throw new \Exception('Brand does not exist');
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $brand = Brand::find($id);

            if ($brand) {
                $brand->delete();
                return response()->json([
                    'message' => 'Brand successfully deleted'
                ], 200);
            } else {
                throw new \Exception('Brand does not exist');
            }
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
