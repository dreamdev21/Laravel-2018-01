<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHpSlidersTable extends Migration
{


    public function up()
    {
        Schema::create('hp_sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img', 255);
            $table->integer('public');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('hp_sliders');
    }
}
