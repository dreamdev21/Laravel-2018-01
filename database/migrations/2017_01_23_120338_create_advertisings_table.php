<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('preroll_name', 255);
            $table->string('preroll_type', 255);
            $table->string('preroll_goto_link', 255);
            $table->string('preroll_mp4', 255);
            $table->string('preroll_skip_timer', 50);
            $table->string('preroll_thumbimg', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisings');
    }
}
