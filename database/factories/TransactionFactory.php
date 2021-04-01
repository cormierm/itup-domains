<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Transaction::class, function (Faker $faker) {

    return [
        'action' => 'update',
        'token' => $faker->uuid,
    ];
});
