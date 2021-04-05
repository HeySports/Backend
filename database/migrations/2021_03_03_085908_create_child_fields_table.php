<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_field');
            $table->foreign('id_field')->references('id')->on('fields')->onDelete('cascade');
            $table->string('name_field')->require();
            $table->string('type')->require();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('child_fields');
    }
}
