<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Entity\User;
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

$factory->define(User::class, function (Faker $faker) {
    $act = $faker->boolean;
    return [
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => null,
        'status' => $act ?  User::STATUS_ACTIVE : User::STATUS_WAIT,
        'email_verified_at' => $act ? \Carbon\Carbon::now() : null,
        'role' => User::ROLE_USER,
        'phone' => null,
        'phone_verified'=>false,
        'phone_verify_token'=>null,
        'phone_verify_token_expire'=>null,
    ];
});
