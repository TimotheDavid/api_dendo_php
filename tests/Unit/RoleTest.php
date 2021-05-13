<?php

namespace Tests\Unit;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RoleTest extends TestCase
{

    public function testCreate(){
        $roleData = [
            'label' => 'label'
        ];

        $response = $this->post('/api/role',$roleData, ['Accept' => 'application/json'])
            ->assertStatus(201);

        DB::table('roles')->where('label', 'label')->delete();
    }


    public function testGetOne(){

        $roleData = DB::table('roles')->get()[0];

        $this->get("api/role/$roleData->id", ['Accept', 'application/json'])
            ->assertStatus(200);
    }

    public function testGet(){

        $this->get('api/role',['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function testUpdate(){

        $data = [
            'label' => 'label',
        ];

        DB::table('roles')->insert($data);

        $roleData = DB::table('roles')->where('label', 'label')->get()[0];

        $this->put("api/role/$roleData->id", [ 'label' => 'autre'], ['Accept' => 'application/json'])
            ->assertStatus(200);

        DB::table('roles')->where('label', 'autre')->delete();

    }
    public function testDelete(){

        $data = [
            'label' => 'label'
        ];

        DB::table('roles')->insert($data);

        $roleData =  DB::table('roles')->select('id')->where('label','label')->get()[0];

        $this->delete("api/role/$roleData->id",[], ['Accept' => 'application/json'])
            ->assertStatus(204);
    }
}
