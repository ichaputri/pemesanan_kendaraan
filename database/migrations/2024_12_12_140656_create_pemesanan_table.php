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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('kendaraan_id')->constrained('kendaraan');
            $table->foreignId('pengelola')->constrained('users');
            $table->foreignId('penyetuju1')->constrained('users');
            $table->foreignId('penyetuju2')->constrained('users');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->enum('status_persetujuan1', ['disetujui', 'ditolak', 'menunggu'])->default('menunggu');;
            $table->enum('status_persetujuan2', ['disetujui', 'ditolak', 'menunggu'])->default('menunggu');;
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
