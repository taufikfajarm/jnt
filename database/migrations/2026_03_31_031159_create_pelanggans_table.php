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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_daftar');
            $table->string('nama');
            $table->string('nik', 16)->unique();
            $table->string('no_hp');
            $table->string('email')->nullable();
            $table->foreignId('kabupaten_id')->constrained('kabupatens');
            $table->foreignId('kecamatan_id')->constrained('kecamatans');
            $table->foreignId('desa_id')->constrained('desas');
            $table->text('alamat_lengkap');
            $table->enum('status_langganan', ['aktif', 'nonaktif', 'isolir', 'berhenti'])->default('aktif');
            $table->foreignId('paket_id')->constrained('pakets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
