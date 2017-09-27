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
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 239,
                'outlet_name' => 'Spare',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 236,
                'outlet_name' => 'Air Bar',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 243,
                'outlet_name' => 'Ents',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 343,
                'outlet_name' => 'Remote Campus Shop',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 241,
                'outlet_name' => 'Liar Bar',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 242,
                'outlet_name' => 'Mono',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 240,
                'outlet_name' => 'Food On Four',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 2677,
                'outlet_name' => 'College Shop',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 239,
                'outlet_name' => 'Dental Café',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 235,
                'outlet_name' => 'DJCAD Cantina',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 235,
                'outlet_name' => 'DOJ Catering',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 456,
                'outlet_name' => 'DUSA The Union: Marketplace',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 456,
                'outlet_name' => 'DUSA The Union: Online',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 237,
                'outlet_name' => 'Floor Five',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 243,
                'outlet_name' => 'Level 2, Reception',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 2679,
                'outlet_name' => 'Ninewells Shop',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 456,
                'outlet_name' => 'Online Dundee University Students Association',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 2676,
                'outlet_name' => 'Premier Shop',
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 343,
                'outlet_name' => 'Premier Shop - Yoyo Accept',
            ]);
    }
}