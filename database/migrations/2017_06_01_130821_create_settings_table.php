<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('language', 3);
            $table->string('color', 10);
            $table->string('ph_name', 30);
            $table->string('ph_address', 30);
            $table->string('ph_telephone', 20);
            $table->string('ph_email', 30);
            $table->string('ph_fax', 20);
            $table->string('ph_print', 1);
            $table->string('currency', 8);
            $table->string('barcode_type', 10);
            $table->timestamps();
        });

        DB::table('settings')->insert([
            'language'     => 'en',
            'color'        => 'white',
            'ph_name'      => 'xxx',
            'ph_address'   => 'xxxx - xxx ',
            'ph_telephone' => 'xxxxxxxx',
            'ph_email'     => 'phm@ph.net',
            'ph_fax'       => 'xxxxxxxxx',
            'ph_print'     => '1',
            'currency'     => 'dollar',
            'barcode_type' => 'QRCODE‎',

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting');
    }
}
