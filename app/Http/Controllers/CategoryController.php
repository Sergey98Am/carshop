<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $categories = Category::OrderBy('id', 'desc')->get();

            return response()->json([
                'categories' => $categories
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function limitedCategories() {
        try {
            $limitedCategories = Category::OrderBy('id', 'desc')->limit(10)->get();

            return response()->json([
                'limitedCategories' => $limitedCategories
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

    public function store(CategoryCreateRequest $request)
    {
        try {
            $category = Category::create([
                'name' => $request->name
            ]);

            if ($category) {
                return response()->json([
                    'message' => 'Category successfully created'
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

    public function update(CategoryUpdateRequest $request, $id)
    {
        try {
            $category = Category::find($id);

            if ($category) {
                $category->update([
                    'name' => $request->name
                ]);
                return response()->json([
                    'message' => 'Category successfully updated'
                ], 200);
            } else {
                throw new \Exception('Category does not exist');
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
            $category = Category::find($id);

            if ($category) {
                $category->delete();
                return response()->json([
                    'message' => 'Category successfully deleted'
                ], 200);
            } else {
                throw new \Exception('Category does not exist');
            }
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
