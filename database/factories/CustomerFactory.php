<?php

use Faker\Generator as Faker;

$factory->define(App\Customer::class, function (Faker $faker) {

    return [
           'customer_reference' => 'user-'.$faker->unique()->randomNumber(3)
    ];
});
