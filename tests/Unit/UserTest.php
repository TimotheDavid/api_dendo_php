<?php

namespace Tests\Unit;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testCreate(){
        $faker = Faker::create();

        $user = [
            'name' => $faker->firstName,
            'email' => $faker->email,
            'password' => 'timdav',
            'role' => 1,
        ];

        $response = $this->post('/api/user', $user, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function testGetOne(){

        $userData = User::findOrFail(1);

        $this->get("/api/user/$userData->id",['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function testGet(){

        $this->get('/api/user', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }



    public function testUpdate(){

        $faker = Faker::create();

        $data = [
            'email' => $faker->email,
            'name' => $faker->name,
            'password' => $faker->password,
            'role' => rand(1,3)
        ];
        try{
            DB::table('users')->insert($data);
        }catch (\Exception $error){
            throw new \Exception('an error in test Update User'. $error);
        }

        $userData = DB::table('users')->where('email', $data['email'])->get()[0];



        $data = [
            'email' => $userData->email,
            'name' => $faker->name,
            'password' => $userData->password,
            'role' => $userData->role
        ];


        $this->put("api/user/$userData->id",$data, ['Accept' => 'application/json'])
            ->assertStatus(204);

        DB::table('users')->where('id', $userData->id)->delete();
    }

    public function testDelete(){
        $faker = Faker::create();

        $data = [
            'email' => $faker->email,
            'name' => $faker->name,
            'password' => $faker->password,
            'role' => rand(1,3),
        ];

        DB::table('users')->insert($data);

        $userData = DB::table('users')->select('id')->where('email', $data['email'])->get()[0];

        $this->delete("api/user/$userData->id",[],['Accept' => 'application/json'])
            ->assertStatus(204);
    }
}
