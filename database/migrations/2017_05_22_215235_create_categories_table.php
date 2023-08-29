<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 40);
            $table->timestamps();
        });

        DB::table('categories')->insert([
            ['name' => 'Phytopathology‎'],
            ['name' => 'Injuries‎'],
            ['name' => 'Cancer'],
            ['name' => 'Animal diseases‎'],
            ['name' => 'Growth disorders‎'],
            ['name' => 'Rare diseases‎'],
            ['name' => 'Neoplasms‎'],
            ['name' => 'Inflammations'],
            ['name' => 'Sleep disorders‎ '],
            ['name' => 'Infectious diseases‎'],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
