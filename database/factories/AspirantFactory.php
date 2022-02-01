<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Aspirant;
use App\Models\AspirantType;
use App\User;
use Faker\Generator as Faker;

$factory->define(Aspirant::class, function (Faker $faker) {

    $persona = User::inRandomOrder()->limit(2)->get();
    return [
        'cc_pdf' => $faker->imageUrl($width = 640, $height = 480),
        'biography' => $faker->text,
        'user_id' => $persona[0]->id,
        'aspirant_type_id' => AspirantType::inRandomOrder()->first()->id
    ];
});
