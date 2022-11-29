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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('toko_store_id')->nullable();
            $table->string('name');
            $table->string('code');
            $table->bigInteger('harga_jual');
            $table->enum('is_hpp', ['yes', 'no'])->default('no');
            $table->bigInteger('hpp');
            $table->enum('is_notif_stock', ['yes', 'no'])->default('no');
            $table->bigInteger('stock');
            $table->bigInteger('stock_minimum');
            $table->string('date');
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
        Schema::dropIfExists('products');
    }
};
