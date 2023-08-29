<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->engine = 'InnoDB';
            $table->increments('p_id');
            $table->string('p_gname', 50)->nullable();
            $table->string('p_bname', 50)->nullable();
            $table->text('p_desc', 255)->nullable();
            $table->string('p_country', 30)->nullable();
            $table->string('p_idnumber', 30)->nullable();
            $table->dateTime('p_imdate')->nullable();
            $table->dateTime('p_exdate')->nullable();
            $table->text('p_seffect', 200)->nullable();
            $table->Integer('p_cat')->unsigned();
            ;
            $table->integer('p_quantity')->nullable();
            $table->integer('p_price')->nullable();
            $table->string('p_imname', 50)->nullable();
            $table->integer('p_imprice')->nullable();
            $table->integer('p_discount')->nullable();
            $table->string('p_image', 30)->nullable();
            $table->string('p_icon', 10)->nullable();
            $table->string('p_barcodeg', 40)->nullable();
            $table->foreign('p_cat')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('products');
    }
}
