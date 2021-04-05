<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Hostname;
use Faker\Generator as Faker;

$factory->define(\App\Transaction::class, function (Faker $faker) {

    return [
        'action' => 'update',
        'hostname_id' => fn () => factory(Hostname::class)->create()->id,
        'token' => $faker->uuid,
    ];
});
