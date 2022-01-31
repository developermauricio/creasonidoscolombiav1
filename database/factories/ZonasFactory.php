<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Zonas;
use Faker\Generator as Faker;

$factory->define(Zonas::class, function (Faker $faker) {
    return [
        'name' => $faker->title,
        'description' => $faker->text
    ];
});
