<?php

use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores')->insert(
            [
                'outlet_reference' => 238,
                'outlet_name' => 'Library',
                'chart_colour' => '#996633'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 239,
                'outlet_name' => 'Spare',
                'chart_colour' => '#543f21'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 236,
                'outlet_name' => 'Air Bar',
                'chart_colour' => '#527dff'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 243,
                'outlet_name' => 'Ents',
                'chart_colour' => '#ff0000'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 343,
                'outlet_name' => 'Remote Campus Shop',
                'chart_colour' => '#009999'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 241,
                'outlet_name' => 'Liar Bar',
                'chart_colour' => '#006600'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 242,
                'outlet_name' => 'Mono',
                'chart_colour' => '#ff6600'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 240,
                'outlet_name' => 'Food On Four',
                'chart_colour' => '#cc99ff'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 2677,
                'outlet_name' => 'College Shop',
                'chart_colour' => '#5c523d'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 239,
                'outlet_name' => 'Dental Cafe',
                'chart_colour' => '#ff9966'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 235,
                'outlet_name' => 'DJCAD Cantina',
                'chart_colour' => '#003300'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 235,
                'outlet_name' => 'DOJ Catering',
                'chart_colour' => '#cccc00'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 456,
                'outlet_name' => 'DUSA The Union: Marketplace',
                'chart_colour' => '#cc00cc'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 456,
                'outlet_name' => 'DUSA The Union: Online',
                'chart_colour' => '#00ffff'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 237,
                'outlet_name' => 'Floor Five',
                'chart_colour' => '#660066'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 243,
                'outlet_name' => 'Level 2, Reception',
                'chart_colour' => '#0000ff'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 2679,
                'outlet_name' => 'Ninewells Shop',
                'chart_colour' => '#666699'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 456,
                'outlet_name' => 'Online DUSA',
                'chart_colour' => '#003399'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 2676,
                'outlet_name' => 'Premier Shop',
                'chart_colour' => '#33cc33'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 343,
                'outlet_name' => 'Premier Shop YoYo',
                'chart_colour' => '#ff66ff'
            ]);
    }
}