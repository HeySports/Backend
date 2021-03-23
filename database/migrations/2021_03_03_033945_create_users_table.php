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
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('phone_numbers')->require()->unique();
            $table->string('address');
            $table->string('avatar')->nullable();
            $table->integer('age')->nullable();
            $table->integer('matches_number')->nullable();
            $table->float('skill_rating')->nullable();
            $table->float('attitude_rating')->nullable();
            $table->string('position_play')->nullable();
            $table->string('description')->nullable();
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
