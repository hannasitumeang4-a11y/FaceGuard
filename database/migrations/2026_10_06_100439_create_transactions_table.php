<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | USER
            |--------------------------------------------------------------------------
            |
            | Setiap transaksi dimiliki oleh user yang sedang login.
            |
            */

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | TYPE
            |--------------------------------------------------------------------------
            |
            | income   = Pendapatan
            | expense  = Pengeluaran
            | withdraw = Penarikan saldo
            | transfer = Transfer
            |
            */

            $table->string('type');


            /*
            |--------------------------------------------------------------------------
            | AMOUNT
            |--------------------------------------------------------------------------
            |
            | Nominal transaksi.
            |
            */

            $table->decimal('amount', 15, 2);


            /*
            |--------------------------------------------------------------------------
            | DESCRIPTION
            |--------------------------------------------------------------------------
            |
            | Keterangan transaksi.
            | Contoh:
            | - Gaji
            | - Belanja
            | - Pembayaran listrik
            | - Penarikan tunai
            |
            */

            $table->text('description')->nullable();


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            |
            | pending = menunggu proses
            | success = berhasil
            | failed  = gagal
            |
            */

            $table->string('status')->default('success');


            /*
            |--------------------------------------------------------------------------
            | TRANSACTION REFERENCE
            |--------------------------------------------------------------------------
            |
            | Nomor/kode transaksi yang dapat digunakan untuk
            | mengidentifikasi transaksi.
            |
            */

            $table->string('reference')->unique();


            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};