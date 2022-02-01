<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AspirantType;
use Faker\Generator as Faker;

$factory->define(AspirantType::class, function (Faker $faker) {

    return [
        'name' => $faker->title,
        'description' => $faker->text
    ];
});
