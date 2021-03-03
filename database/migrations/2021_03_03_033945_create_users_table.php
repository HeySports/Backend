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
            $table->unsignedBigInteger('id_districts');
            $table->foreign('id_roles')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('id_districts')->references('id')->on('da_nang')->onDelete('cascade');
            $table->string('full_name')->require();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_numbers')->require()->unique();
            $table->string('address');
            $table->string('avatar');
            $table->date('date_of_birth');
            $table->integer('matches_number');
            $table->float('rating');
            $table->string('status');
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
