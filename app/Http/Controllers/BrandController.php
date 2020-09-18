<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');

        $validator = Validator::make($request->all(), [
           'name' => 'required|min:2|max:255|unique:brands,name,'
       ]);
       if($validator->fails()){
           return response()->json($validator->errors()->toJson(), 400);
       }

       // $validated = $request->validated();

       $brand = new Brand();
       $brand->fill($input);
       $brand->save();

       return response()->json(['name' => $brand->name.':is Created']);
        // return redirect()->route('brand.index')->with('message','Success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except('_token','_method','id');

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255|unique:brands,name,'.$id
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        // $validated = $request->validated();

        $brand = Brand::find($id);
        $brand->fill($input);
        $brand->update();

        return response()->json(['name' => $brand->name.':is Updated']);
        // return redirect()->route('brand.index')->with('message','Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Brand::find($id);
        $destroy->delete();

        return response()->json(['name' => $destroy->name.':is Deleted']);
        // return redirect()->route('category.index')->with('message','Success!');
    }
}
