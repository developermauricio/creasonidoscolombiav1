<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Aspirant;
use App\Models\AspirantType;
use \App\Models\Ethnic;
use \App\CategoryAspirant;
use App\User;
use Faker\Generator as Faker;

$factory->define(Aspirant::class, function (Faker $faker) {
    $answer = array('Si', 'No');
    return [
        'cc_document_pdf' => $faker->imageUrl($width = 640, $height = 480),
        'extension_document' => 'png',
        'accept_termi' => random_int(1, 2),
        'biography' => $faker->text,
        'aspirant_type_id' => AspirantType::inRandomOrder()->first()->id,
        'ethnic_id' => Ethnic::inRandomOrder()->first()->id,
        'category_aspirant_id' => CategoryAspirant::inRandomOrder()->first()->id,
        'head_house_hold' => $answer[rand(0, count($answer) - 1)],
        'victim_conflict' => $answer[rand(0, count($answer) - 1)],
        'disability' => $answer[rand(0, count($answer) - 1)],
        'vinculado_ecopetrol' => "Si",
        'primer_empleo_ecopetrol' => $answer[rand(0, count($answer) - 1)],
        'bachilleres_colombia_ecopetrol' => $answer[rand(0, count($answer) - 1)],
    ];
});
