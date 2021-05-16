<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');       
            $table->string('name_room')->unique()->require();
            $table->string('address')->nullable();
            $table->string('field_name')->nullable();
            $table->boolean('lock')->nullable();
            $table->string('password')->nullable();
            $table->dateTime('time_start_play')->nullable();
            $table->dateTime('time_end_play')->nullable();
            $table->string('description')->nullable();
            $table->string('lose_pay')->nullable();
            $table->integer('type')->nullable();
            $table->integer('type_field')->nullable();
            $table->float('price')->require();
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
        Schema::dropIfExists('matches');
    }
}
