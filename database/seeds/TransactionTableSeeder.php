<?php
use Illuminate\Database\Seeder;
class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trans = factory(App\Transaction::class, 20)->create();

    }
}