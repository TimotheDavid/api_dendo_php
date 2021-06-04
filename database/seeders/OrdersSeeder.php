<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i<10; $i++) {
                DB::table('orders')->insert([
                    'amount_vat' => $faker->numberBetween(0,1000),
                    'amount_ttc' => $faker->numberBetween(0,1000),
                    'user' => $faker->numberBetween(1,10),
                    'done' => $faker->boolean
                ]);
        }
    }
}
