<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_match');
            $table->foreign('id_match')->references('id')->on('matches')->onDelete('cascade');
            $table->unsignedBigInteger('id_child_field');
            $table->foreign('id_child_field')->references('id')->on('child_fields')->onDelete('cascade');
            $table->time('time_start')->require();
            $table->time('time_end')->require();
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
        Schema::dropIfExists('orders');
    }
}
