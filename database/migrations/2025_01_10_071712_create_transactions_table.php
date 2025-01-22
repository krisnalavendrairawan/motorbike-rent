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
            $table->unsignedBigInteger('rental_id');
            $table->foreign('rental_id')->references('id')->on('rental')->onDelete('cascade');
            $table->string('status');
            $table->string('payment_type')->default('qris'); // tipe pembayaran (di-set 'qris' untuk QR saja)
            $table->string('order_id')->unique(); // ID pesanan unik dari Midtrans
            $table->string('transaction_id')->nullable(); // ID transaksi dari Midtrans
            $table->string('qris_url')->nullable(); // URL QR code untuk pembayaran QRIS
            $table->timestamp('transaction_time')->nullable(); // waktu transaksi dari Midtrans
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
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
