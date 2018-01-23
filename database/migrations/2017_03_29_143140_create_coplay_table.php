<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoplayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coplay', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inv_from');
            $table->integer('inv_to');
            $table->integer('inv_mov_id');
            $table->integer('payment_id');
            $table->string('exp_date', 50);
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
        Schema::dropIfExists('coplay');
    }
}

