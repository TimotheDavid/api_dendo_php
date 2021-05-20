<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for($i = 0; $i<10; $i++){
            DB::table('products')->insert([
                'price_vat' => $faker->numberBetween(0,1000),
                'price_ttc' => $faker->numberBetween(0,1000),
                'name' => $faker->name,
                'description' => $faker->sentence,
                'stock' => $faker->randomNumber(3, false),
                'focus' => $faker->boolean,
                'place' => $faker->randomDigit(),
                'rank' => $faker->randomDigit(),
                'picture' => 1
            ]);
        }
    }
}
