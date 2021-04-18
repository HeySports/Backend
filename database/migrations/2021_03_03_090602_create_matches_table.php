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
            $table->unsignedBigInteger('id_field_play');
            $table->foreign('id_field_play')->references('id')->on('fields')->onDelete('cascade');
            $table->unsignedBigInteger('id_child_field');
            $table->foreign('id_child_field')->references('id')->on('child_fields')->onDelete('cascade');
            $table->string('name_room')->unique()->require();
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
