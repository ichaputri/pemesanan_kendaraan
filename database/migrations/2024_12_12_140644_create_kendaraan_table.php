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
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('jenis_kendaraan_id')->constrained('jenis_kendaraan')->onDelete('cascade');
            $table->string('nama_kendaraan');
            $table->string('nomor_polisi')->unique();
            $table->enum('status', ['milik perusahaan', 'sewa']);
            $table->enum('ketersediaan', ['tersedia', 'sedang dipakai'])->default('tersedia');
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
