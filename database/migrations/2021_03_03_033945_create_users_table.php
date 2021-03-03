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
            $table->unsignedBigInteger('id_roles');
            $table->foreign('id_roles')->references('id')->on('roles')->onDelete('cascade');
            $table->string('full_name')->require();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_numbers')->require()->unique();
            $table->string('address');
            $table->string('avatar');
            $table->integer('age');
            $table->integer('matches_number');
            $table->float('skill_rating');
            $table->float('attitude_rating');
            $table->string('position_play');
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
        Schema::dropIfExists('users');
    }
}
