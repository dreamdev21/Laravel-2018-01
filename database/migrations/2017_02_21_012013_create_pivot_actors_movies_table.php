<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotActorsMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actors_movies', function(Blueprint $table)
        {
            $table->Bigincrements('id');
            $table->bigInteger('actor_id')->index()->unsigned();
            $table->bigInteger('movie_id')->index()->unsigned();
            $table->string('char_name', 255)->default('Unknown');
            $table->tinyInteger('known_for')->default(0)->unsigned();
            $table->timestamp('created_at')->default( DB::raw('CURRENT_TIMESTAMP') );
            $table->timestamp('updated_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('actors_movies');
    }
}
