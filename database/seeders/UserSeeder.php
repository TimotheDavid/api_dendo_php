<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $manager = DB::table('roles')->select('id')->where('label', 'manager')->get()[0];

        DB::table('users')->insert([
           'name' => 'admin',
            'last' => 'admin',
            'email' => 'admin@admin',
            'password' => bcrypt('administrator'),
            'role' => $manager->id


        ]);
        for($i = 0 ; $i< 10; $i++) {
            DB::table('users')->insert([
                'name' => $faker->firstName,
                'last' => $faker->lastName,
                'email' => $faker->email,
                'password' => $faker->password,
                'role' => rand(1,3)
            ]);
        }
    }


}
