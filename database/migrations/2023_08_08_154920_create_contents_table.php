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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('week')->nullable();
            $table->string('title')->nullable();
            $table->string('description', 10000)->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('stage_id');
            $table->timestamps();

            $table->foreign('stage_id')->references('id')->on('stages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
};
