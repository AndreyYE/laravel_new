<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(\App\Entity\Region::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->city,
        'slug' => $faker->unique()->slug(2),
        'parent_id' => null
    ];
});
