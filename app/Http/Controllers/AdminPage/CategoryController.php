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

    public function index()
    {
        $categories = Category::OrderBy('id','desc')->get();

        return response()->json(['categories' => $categories]);
    }

    public function create()
    {
        return view('category_create');
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');

         $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255|unique:categories,name'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        // $validated = $request->validated();

        $category = new Category();
        $category->fill($input);
        $category->save();

        return response()->json(['message' => 'Category successfully created']);

        // return redirect()->route('category.index')->with('message','Success!');
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('category_edit',compact('category'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->except('_token','_method','id');

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255|unique:categories,name,'.$id
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        // $validated = $request->validated();

        $category = Category::find($id);
        $category->fill($input);
        $category->update();

        return response()->json(['message' => 'Category successfully updated']);
        // return redirect()->route('category.index')->with('message','Success!');
    }

    public function destroy($id)
    {
        $destroy = Category::find($id);
        $destroy->delete();

        return response()->json(['message' => 'Category successfully deleted']);
        // return redirect()->route('category.index')->with('message','Success!');
    }
}
