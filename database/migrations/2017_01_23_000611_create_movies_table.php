<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('type', 15)->default('movie')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('duration')->nullable();
            $table->integer('year')->default(0);
            $table->string('url')->nullable();
            $table->integer('period')->default(0);
            $table->decimal('price', 19, 2)->default(0);
            $table->integer('genre_id')->nullable();
            $table->string('poster', 255)->nullable();
            $table->string('bg_poster', 255)->nullable();
            $table->boolean('available')->default(1);
            $table->integer('parental_id')->nullable();
            $table->integer('studio_id')->nullable();
            $table->integer('director_id')->nullable();
            $table->string('actors')->nullable();
            $table->tinyInteger('season_number')->nullable()->unsigned();


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
        Schema::dropIfExists('movies');
    }
}
