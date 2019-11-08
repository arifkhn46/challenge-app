<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Challenge;
use Faker\Generator as Faker;

$factory->define(Challenge::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'days' => 21,
        'owner_id' => factory(App\User::class)
    ];
});
