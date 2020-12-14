<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Shop;
use App\Models\User;

$factory->define(Shop::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'user_id' => User::where('role_id', 2)->get()->random()->id,
    ];
});
