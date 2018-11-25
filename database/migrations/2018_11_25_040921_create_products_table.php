<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_barang');
            $table->integer('point');
            $table->timestamps();
        });
        DB::table('products')->insert(
            [
                ['nama_barang' => 'baju','point'=>50],
                ['nama_barang' => 'mug','point'=>25],
                ['nama_barang' => 'gelang','point'=>10],
                ['nama_barang' => 'kalung','point'=>10],
                ['nama_barang' => 'gelang kaki','point'=>10],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
