<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderLinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for($i = 0; $i < 10; $i++){
            DB::table('order_lines')->insert([
                'price_vat' => $faker->numberBetween(0,2000),
                'stock' => $faker->numberBetween(0,10000),
                'products' => $faker->numberBetween(1,10),
                'orders' => $faker->numberBetween(1,10),
            ]);

        }
    }
}
