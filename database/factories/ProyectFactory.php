<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Proyect;
use Faker\Generator as Faker;

$factory->define(\App\Models\Proyect::class, function (Faker $faker) {
    $title = $faker->name;
    $audios = array(
        'https://aicode.sfo3.digitaloceanspaces.com/crea-sonidos/audios/Yuri-Buenaventura-No%20Estoy%20Contigo.mp3',
        'https://aicode.sfo3.digitaloceanspaces.com/crea-sonidos/audios/Yuri-Buenaventura-Tu-Cancion.mp3',
    );
    return [
        'title'=>$title,
        'description'=>$faker->sentence,
        'name_author'=>$faker->name.' '.$faker->lastName,
        'category_by_aspirant'=>$faker->title,
        'category_id' => \App\Models\Category::all()->random()->id,
        'state'=> \App\Models\Proyect::REVISION,
        'slug'=> \Illuminate\Support\Str::slug($title, '-'),
        'audio' => "https://creasonidos-colombia.s3.sa-east-1.amazonaws.com/projects/que-hay-de-malo-boris-rene-velez-coy-que-hay-de-malo-boris-velezmp3-principal-0rm2dxjzdl.mp3"
    ];
});
