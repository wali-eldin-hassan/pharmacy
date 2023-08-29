<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custorders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->bigInteger('cust_no');
            $table->string('info', 150)->nullable();
            $table->integer('price');
            $table->tinyInteger('quantity');
            $table->integer('product_id')->unsigned();
            $table->foreign('cust_no')->references('number')->on('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('p_id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custorders');
    }
}
