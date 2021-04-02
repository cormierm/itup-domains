<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\AllowedEmail::class, function (Faker $faker) {

    return [
        'email' => $faker->email,
    ];
});
