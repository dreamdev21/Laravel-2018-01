<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id'); // A payment belongs to a user
            $table->string('transaction_id'); //id for the transaction
            $table->integer('movie_id');
            $table->boolean('failed')->nullable();
            $table->decimal('amount', 19, 2)->default('0');
            $table->integer('season_id')->nullable();
            $table->integer('episode_id')->nullable();
            $table->timestamp('valid_until');
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
        Schema::dropIfExists('payments');
    }
}
