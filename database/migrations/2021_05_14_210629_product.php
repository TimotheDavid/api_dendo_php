<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
           $table->id();
           $table->timestamps();
           $table->double('price_vat');
           $table->double('price_ttc');
           $table->string('name');
           $table->string('description');
           $table->integer('stock');
           $table->boolean('focus');
           $table->integer('place');
           $table->integer('rank');
           $table->foreignId('picture')->references('id')->on('pictures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
