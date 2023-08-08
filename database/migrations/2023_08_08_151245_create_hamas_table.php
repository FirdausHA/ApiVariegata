<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tipe');
            $table->string('image');
            $table->string('description',1000);
            $table->string('cegah',10000);
            $table->unsignedBigInteger('plant_id');
            $table->timestamps();
            
            $table->foreign('plant_id')->references('id')->on('plants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hamas');
    }
};
