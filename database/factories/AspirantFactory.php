<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Aspirant;
use App\Models\AspirantType;
use App\User;
use Faker\Generator as Faker;

$factory->define(Aspirant::class, function (Faker $faker) {
    return [
        'cc_document' => $faker->imageUrl($width = 640, $height = 480),
        'extension_document' => 'png',
        'accept_termi' => random_int(1, 2),
        'biography' => $faker->text,
        'aspirant_type_id' => AspirantType::inRandomOrder()->first()->id
    ];
});
