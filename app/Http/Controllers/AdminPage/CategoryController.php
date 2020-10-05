<?php

namespace App\Http\Controllers\AdminPage;

use App\Http\Controllers\Controller;
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
        $categories = Category::OrderBy('id','desc')->get();

        return response()->json([
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(CategoryCreateRequest $request)
    {
        $category = Category::create([
            'name' => $request->name
        ]);

        if ($category) {
            return response()->json([
                'message' => 'Category successfully created'
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
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->update([
                'name' => $request->name
            ]);
            return response()->json([
                'message' => 'Category successfully updated'
            ], 200);
        } else {
            return response()->json([
                'error' => 'category does not exist'
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
        $destroy = Category::find($id);

        if ($destroy) {
            $destroy->delete();
            return response()->json([
                'message' => 'Category successfully deleted'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Category does not exist'
            ], 400);
        }
    }
}
