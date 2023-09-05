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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_code');
            $table->integer('product_id');
            $table->integer('user_id');
            $table->bigInteger('alamat_id');
            $table->enum('status_diulas', ['menunggu diulas', 'sudah diulas'])->default('menunggu diulas');
            $table->enum('status', ['Menunggu pembayaran', 'Menunggu konfirmasi', 'Sedang disiapkan', 'Menunggu driver', 'Sedang diantar', 'Selesai'])->default('Menunggu pembayaran');
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
};
