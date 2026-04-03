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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            $table->integer('bulan'); // 1-12
            $table->integer('tahun'); // YYYY
            $table->date('tanggal_bayar')->nullable();
            $table->string('status_pembayaran')->default('belum_bayar'); // belum_bayar, lunas
            $table->string('keterangan')->nullable();
            $table->timestamps();
            
            $table->unique(['pelanggan_id', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
