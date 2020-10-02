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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::all();
        return response()->json(['cars' => $cars]);
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
           'name' => 'required|min:2|max:255|unique:cars,name',
           'price' => 'required',
           'condition' => 'required',
           'year' => 'required',
           'color' => 'required',
           'speed' => 'required',
           'category_id' => 'exists:categories,id',
           'brand_id' => 'exists:brands,id'
       ]);
       if($validator->fails()){
           return response()->json($validator->errors()->toJson(), 400);
       }

       // $validated = $request->validated();

       $car = new Car();
       $car->fill($input);
       $car->save();

       return response()->json(['message' => 'Car successfully created']);
        // return redirect()->route('car.index')->with('message','Success!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except('_token','_method','id');

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
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        // $validated = $request->validated();

        $car = Car::find($id);
        $car->fill($input);
        $car->update();

        return response()->json(['message' => 'Car successfully updated']);
        // return redirect()->route('car.index')->with('message','Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Car::find($id);
        $destroy->delete();

        return response()->json(['message' => 'Car successfully deleted']);
        // return redirect()->route('category.index')->with('message','Success!');
    }


    public function uploadImage(Request $request, $id){
       
        $validator = Validator::make($request->all(), [
            'image' => 'mimes:jpeg,jpg,png,gif|required'
        ]);
       if($validator->fails()){
           return response()->json($validator->errors()->toJson(), 400);
       }
            $car = Car::find($id);
            $file = $request->file('image');
            $file_name = time().$file->getClientOriginalName();
            $file->move(public_path().'/images/',$file_name);
            $car->image = $file_name;
            $car->save();
            return response()->json(['message' => 'Image successfully created']);
    }
}
