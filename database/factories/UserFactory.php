<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\City;
use App\Models\DocumentType;
use App\Models\Gender;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {

    $nombre = $faker->name;
    $apellido = $faker->lastName;
    return [

        'document' => $faker->creditCardNumber,
        'name' => $nombre,
        'last_name' => $apellido,
        'user_name' => $nombre . '-' . $apellido,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'slug' => $nombre . '-' . $apellido,
        'picture' => $faker->imageUrl($width = 640, $height = 480),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'url_facebook' => $faker->text,
        'url_youtube' => $faker->text,
        'url_instagram' => $faker->text,
        'url_tiktok' => $faker->text,
        'url_snapchat' => $faker->text,
        'url_spotify' => $faker->text,
        'url_apple_music' => $faker->text,
        'url_deezer' => $faker->text,
        'web_site' => $faker->text,
        'state' => rand(1, 2),
        'address' => $faker->address,
        'document_type_id' => DocumentType::inRandomOrder()->first()->id,
        'gender_id' => Gender::inRandomOrder()->first()->id,
        'city_id' => City::inRandomOrder()->first()->id,
        'remember_token' => Str::random(10)
    ];
});
