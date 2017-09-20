<?php

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {

    $cash = $faker->randomFloat(2, 0, 999);
    $discount = 0-$faker->randomFloat(2, 0, 999);
    $customer = App\Customer::pluck('id')->All();
    $store = App\Store::pluck('id')->All();

    return [
        'customer_id' => $faker->randomElement($customer),
        'store_id' => $faker->randomElement($store),
        'date' => $faker->dateTimeThisMonth(),
        'transaction_type' => $faker->randomElement(['Payment', 'Refund', 'Redemption']),
        'cash_spent' => $cash,
        'discount_amount' => $discount,
        'total_amount' => $cash + $discount,
        'transaction_hash' => $faker->md5
    ];
});