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
        Schema::create('credit_cash_flows', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('toko_store_id')->nullable();
            $table->string('nama_pelanggan');
            $table->enum('type', ['memberi','menerima']);
            $table->bigInteger('nominal');
            $table->text('catatan');
            $table->string('date');
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
        Schema::dropIfExists('credit_cash_flows');
    }
};
