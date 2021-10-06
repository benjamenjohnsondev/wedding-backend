<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('party_name');
            $table->string('greeting_name');
            $table->string('password');
            $table->boolean('rsvp')->nullable();
            $table->boolean('plus_one')->nullable();
            $table->integer('expected_attending');
            $table->integer('total_attending')->nullable();
            $table->json('meal_choice')->nullable();
            $table->string('song_recommendations')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
