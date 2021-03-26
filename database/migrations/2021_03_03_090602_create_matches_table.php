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
            $table->unsignedBigInteger('id_field_play');
            $table->foreign('id_field_play')->references('id')->on('fields')->onDelete('cascade');
            $table->string('name_room')->unique()->require();
            $table->boolean('lock')->nullable();
            $table->string('password')->nullable();
            $table->time('time_start_play')->nullable();
            $table->time('time_end_play')->nullable();
            $table->string('description')->nullable();
            $table->string('lose_pay')->nullable();
            $table->integer('type')->nullable();
            $table->float('price')->nullable();
            $table->integer('type_field')->nullable();
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
