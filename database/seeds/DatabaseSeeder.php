<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'is_admin' => true
        ]);

        $this->call(CustomerTableSeeder::class);
        $this->call(StoreTableSeeder::class);
        $this->call(TransactionTableSeeder::class);
        $this->call(ColoursTableSeeder::class);
    }
}
