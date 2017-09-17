<?php
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
$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
        'customer_id' => $faker->numberBetween(0, 123456),
        'store_id' => $faker->numberBetween(0, 12),
        'date' => $faker->dateTimeThisMonth(),
        'transaction_type' => $faker->randomElement(["Discount", "Refund", "Payment"]),
        'cash_spent' => $faker->randomFloat(2, 0, 999),
        'discount_amount' => $faker->randomFloat(2, 0, 999),
        'total_amount' => $faker->randomFloat(2, 0, 999),
        'transaction_hash' => str_random(13),
    ];
});