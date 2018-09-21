<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Flyer::class, function (Faker $faker) {


    return [
        'user_id'=>factory('App\User')->create()->id,
        'street' => $faker->streetAddress,
        'city' => $faker->city,
        'zip' => $faker->postcode,
        'states' => $faker->state,
        'country' => $faker->country,
        'price' =>$faker->numberBetween(10000 , 500000),
        'description' =>$faker->paragraph
    ];
});

