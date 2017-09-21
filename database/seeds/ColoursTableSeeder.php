<?php

use Illuminate\Database\Seeder;

class ColoursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colours')->insert(
            [
                'store' => 'Library',
                'chart_colour' => '#996633'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Spare',
                'chart_colour' => '#543f21'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Air Bar',
                'chart_colour' => '#527dff'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Ents',
                'chart_colour' => '#ff0000'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Remote Campus Shop',
                'chart_colour' => '#009999'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Liar Bar',
                'chart_colour' => '#006600'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Mono',
                'chart_colour' => '#ff6600'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Food On Four',
                'chart_colour' => '#cc99ff'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'College Shop',
                'chart_colour' => '#5c523d'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Dental Cafe',
                'chart_colour' => '#ff9966'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'DJCAD Cantina',
                'chart_colour' => '#003300'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'DOJ Catering',
                'chart_colour' => '#cccc00'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'DUSA The Union: Marketplace',
                'chart_colour' => '#cc00cc'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'DUSA The Union: Online',
                'chart_colour' => '#00ffff'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Floor Five',
                'chart_colour' => '#660066'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Level 2, Reception',
                'chart_colour' => '#0000ff'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Ninewells Shop',
                'chart_colour' => '#666699'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Online DUSA',
                'chart_colour' => '#003399'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Premier Shop',
                'chart_colour' => '#33cc33'
            ]);
        DB::table('colours')->insert(
            [
                'store' => 'Premier Shop - Yoyo Accept',
                'chart_colour' => '#ff66ff'
            ]);
    }
}