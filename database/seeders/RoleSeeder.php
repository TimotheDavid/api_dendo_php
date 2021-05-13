<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['manager', 'user', 'vendeur'];

        foreach ($roles as $item ){
            DB::table('roles')->insert([
                'label' => $item
            ]);
        }
    }
}
