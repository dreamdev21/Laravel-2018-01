<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('episode_name', 255);
            $table->unsignedInteger('movie_id');
            $table->integer('season_number')->default(1)->unsigned();
            $table->integer('episode_number');
            $table->text('episode_description')->nullable();
            $table->string('episode_thumbnail', 255)->nullable();
            $table->string('episode_source');
            $table->decimal('episode_price')->default(0);
            $table->integer('episode_period')->default(0);
            $table->decimal('duration')->nullable(0);
            $table->timestamps();


            $table->unique(array('episode_number', 'season_number', 'movie_id'), 'ep_s_title_unique');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episodes');
    }
}
