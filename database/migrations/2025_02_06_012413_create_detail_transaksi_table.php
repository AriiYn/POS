<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('detail_transaksi')) {
            Schema::create('detail_transaksi', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('transaksi_id');
                $table->unsignedBigInteger('produk_id');
                $table->decimal('total_harga', 55, 0);
                $table->integer('quantity');
                $table->decimal('subtotal', 55, 0);
                $table->timestamps();
                $table->foreign('transaksi_id')
                      ->references('id')->on('transaksis')
                      ->onDelete('cascade');

                $table->foreign('produk_id')
                    ->references('id')->on('produks')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('detail_transaksi');
    }
}
