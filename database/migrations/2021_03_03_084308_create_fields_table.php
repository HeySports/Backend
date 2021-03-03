<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_owner');
            $table->foreign('id_owner')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->unique()->require();
            $table->float('rating');
            $table->string('list_image');
            $table->string('address')->unique()->require();
            $table->string('email_field')->require()->unique();
            $table->string('phone_numbers')->require()->unique();
            $table->boolean('status');
            $table->integer('quantities_field');
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
        Schema::dropIfExists('fields');
    }
}
