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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('toko_store_id')->nullable();
            $table->unsignedInteger('category_cash_out_id')->nullable();
            $table->enum('type_transaction', ['pemasukan', 'pengeluaran']);
            $table->enum('type_pay', ['lunas', 'belum_lunas']);
            $table->enum('methode_catatan', ['kasir', 'manual']);
            $table->bigInteger('nominal_penjualan');
            $table->bigInteger('nominal_hpp');
            $table->bigInteger('keuntungan');
            $table->text('note');
            $table->string('date');
            $table->unsignedInteger('payment_id')->nullable();
            $table->unsignedInteger('channel_id')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
