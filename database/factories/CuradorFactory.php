<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Curador;
use Faker\Generator as Faker;

$factory->define(\App\Models\Curador::class, function (Faker $faker) {
    return [
        'biography' => $faker->sentence
    ];
});
