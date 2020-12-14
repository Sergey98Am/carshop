<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Car;
use App\Models\Category;
use App\Models\Shop;
use App\Models\Brand;


$factory->define(Car::class, function (Faker $faker) {
    return [
        'image' => 'mercedes.jpg',
        'name' => $faker->sentence(2),
        'price' => $faker->numberBetween($min = 2000, $max = 90000),
        'condition' => $faker->randomElement(['New', 'Old']),
        'year' => $faker->year,
        'color' => $faker->colorName,
        'speed' => $faker->numberBetween($min = 250, $max = 550),
        'quantity' => $faker->randomDigitNot(0),
        'category_id' => Category::all()->random()->id,
        'shop_id' => Shop::all()->random()->id,
        'brand_id' => Brand::all()->random()->id,
    ];
});
