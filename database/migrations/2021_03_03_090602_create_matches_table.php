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
            $table->boolean('lock');
            $table->string('password');
            $table->time('time_start_play');
            $table->time('time_end_play');
            $table->string('description');
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
