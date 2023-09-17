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
        Schema::create('product_crosells', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description', 10000);
            $table->decimal('price');
            $table->string('image')->nullable();
            $table->integer('stock');
            $table->timestamp('expiry_time');
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
        Schema::dropIfExists('product_crosells');
    }
};