<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $cars = Car::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('price', 'LIKE', '%' . $request->search . '%')
                ->orWhere('condition', 'LIKE', '%' . $request->search . '%')
                ->orWhere('year', 'LIKE', '%' . $request->search . '%')
                ->orWhere('color', 'LIKE', '%' . $request->search . '%')
                ->orWhere('speed', 'LIKE', '%' . $request->search . '%')
                ->get();

            if ($cars->count() > 0) {
                return response()->json([
                    'cars' => $cars
                ], 200);
            } else {
                throw new \Exception('Nothing found');
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
