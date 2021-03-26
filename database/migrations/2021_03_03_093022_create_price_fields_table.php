<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_field');
            $table->foreign('id_field')->references('id')->on('fields')->onDelete('cascade');
            $table->integer('type_field')->require();
            $table->time('time_start')->require();
            $table->time('time_end')->require();
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
        Schema::dropIfExists('price_fields');
    }
}
