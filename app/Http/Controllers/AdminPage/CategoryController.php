<?php

namespace App\Http\Controllers\AdminPage;

use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Category;
use JWTAuth;
use Validator;

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

    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255|unique:categories,name'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toJson()
            ], 400);
        }

        Category::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Category successfully created'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255|unique:categories,name,'.$id
        ]);
        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()->toJson()
            ], 400);
        }

        $category = Category::find($id);
        if ($category) {
            $category->create([
                'name' => $request->name
            ]);
        } else {
            return response()->json([
                'error' => 'category does not exist'
            ], 400);
        }

        return response()->json([
            'message' => 'Category successfully updated'
        ]);
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
            return response()->json([
                'message' => 'Category successfully deleted'
            ],200);
        } else {
            return response()->json([
                'error' => 'Category does not exist'
            ], 400);
        }
    }
}
