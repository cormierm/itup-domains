<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Hostname;
use Faker\Generator as Faker;

$factory->define(Hostname::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'email' => $faker->email,
        'ip' => $faker->ipv4,
        'token' => $faker->uuid,
        'expires_at' => \Carbon\Carbon::now()->toDateTimeString(),
    ];
});
