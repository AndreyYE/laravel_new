<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entity\Adverts\Advert\Advert;
use Faker\Generator as Faker;

$factory->define(Advert::class, function (Faker $faker) {
    $region = \App\Entity\Region::first();
    return [
        'user_id'=>\App\Entity\User::first()->id,
        'category_id'=>\App\Entity\Adverts\Category::first()->id,
        'region_id'=>$region->id,
        'title'=> $faker->title,
        'price'=>$faker->numberBetween(1,1000),
        'address'=> $region->name,
        'content'=> $faker->text,
        'status'=>Advert::STATUS_DRAFT,
        'promotion'=>0,
        'created_at'=> \Carbon\Carbon::now(),
        'updated_at'=>\Carbon\Carbon::now()
    ];
});
