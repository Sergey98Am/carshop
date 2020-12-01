<?php

namespace App\Http\Controllers;

use App\Models\Car;


class FrontController extends Controller
{
    public function recommended()
    {
        try {
            $recommendedCars = Car::inRandomOrder()->limit(10)->get();

            return response()->json([
                'recommendedCars' => $recommendedCars
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
