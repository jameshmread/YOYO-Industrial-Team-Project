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
                'outlet_name' => 'Library'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 239,
                'outlet_name' => 'Spare'
            ]);
        DB::table('stores')->insert(
            [
            'outlet_reference' => 236,
                'outlet_name' => 'Air Bar'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 243,
                'outlet_name' => 'Ents'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 343,
                'outlet_name' => 'Remote Campus Shop'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 241,
                'outlet_name' => 'Liar Bar'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 242,
                'outlet_name' => 'Mono'
            ]);
        DB::table('stores')->insert(
            [
                'outlet_reference' => 240,
                'outlet_name' => 'Food On Four'
            ]);
    }
}
