<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Test',
            'email' =>'admin@gmail.com',
            'password' => bcrypt('password'),
            'is_admin' => '1',
        ]);
    }
}
