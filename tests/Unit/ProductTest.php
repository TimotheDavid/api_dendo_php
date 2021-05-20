<?php

namespace Tests\Unit;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;


CONST APPLICATION=['Accept' => 'application/json'];
class ProductTest extends TestCase
{

    public function testCreate(){
        $product = $this->data();

        $this->post('api/product',$product, APPLICATION)
            ->assertStatus(201);

        DB::table('products')->where('name', $product['name'])->delete();
    }

    public function testGetOne(){
        $productData = DB::table('products')->where('id', 1)->get()[0];


        $this->get("api/product/$productData->id", APPLICATION )
            ->assertStatus(200);
    }

    public function testGet(){
        $this->get('api/user/product', APPLICATION)
            ->assertStatus(200);
    }

    public function testUpdate(){

        $productData = $this->data();

        $data = Product::create($productData);
        $data->name = "un produit";

        $dataProduct = [
            'price_vat' => $data->price_vat,
            'price_ttc' => $data->price_ttc,
            'name' =>  $data->name,
            'description' => $data->description,
            'stock' => $data->stock,
            'focus' => $data->focus,
            'place' => $data->place,
            'rank' => $data->rank,
            'picture' => $data->picture
        ];



        $this->put("api/product/$data->id", $dataProduct, APPLICATION)
            ->assertStatus(200);

        DB::table('products')->where('id', $data->id)->delete();

    }

    public function testDelete(){
        $productData = $this->data();

        $data = Product::create($productData);

        $this->delete("api/product/$data->id", [], APPLICATION)
            ->assertStatus(204);

    }


    public function data(){
        $faker = Factory::create();
        return  [
            'price_vat' => $faker->randomFloat(2),
            'price_ttc' => $faker->randomFloat(2),
            'name' => $faker->name,
            'description' => $faker->sentence,
            'stock' => $faker->randomNumber(3, false),
            'focus' => $faker->boolean,
            'place' => $faker->randomDigit(),
            'rank' => $faker->randomDigit(),
            'picture' => 1
        ];
    }


}
