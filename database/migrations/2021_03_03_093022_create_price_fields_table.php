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
            $table->unsignedBigInteger('id_child_field');
            $table->foreign('id_child_field')->references('id')->on('child_fields')->onDelete('cascade');
            $table->time('time_start')->require();
            $table->time('time_end')->require();
            $table->float('price')->require();
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
        Schema::dropIfExists('price_fields');
    }
}
