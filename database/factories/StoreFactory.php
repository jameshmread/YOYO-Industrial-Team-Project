<?php

use Faker\Generator as Faker;

$factory->define(App\Store::class, function (Faker $faker) {

    $outlet = $faker->randomElement(['Library', 'Spare', 'Air Bar', 'Ents', 'Remote Campus Shop',
        'Liar Bar', 'Mono', 'Food on Four']);

    $outref = null;

    if($outlet == 'Library')
    {
        $outref = 238;
    }
    else if($outlet == 'Spare')
    {
        $outref = 239;
    }
    else if($outlet == 'Air Bar')
    {
        $outref = 236;
    }
    else if($outlet == 'Ents')
    {
        $outref = 243;
    }
    else if($outlet == 'Remote Campus Shop')
    {
        $outref = 343;
    }
    else if($outlet == 'Liar Bar')
    {
        $outref = 241;
    }
    else if($outlet == 'Mono')
    {
        $outref = 242;
    }
    else
    {
        $outref = 240;
    }

    return [
        'outlet_reference' => $outref,
        'outlet_name' => $outlet
    ];
});
