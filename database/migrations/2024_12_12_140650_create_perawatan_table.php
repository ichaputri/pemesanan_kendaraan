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
        Schema::create('perawatan', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('kendaraan_id')->constrained('kendaraan')->onDelete('cascade'); // Relasi ke kendaraan
            $table->date('tanggal_perawatan'); // Tanggal perawatan dilakukan
            $table->decimal('bbm', 10, 2); // Jumlah BBM yang digunakan (misalnya liter)
            $table->date('jadwal_service'); // Jadwal perawatan berikutnya
            $table->text('riwayat_pakai')->nullable(); // Riwayat penggunaan kendaraan
            $table->text('keterangan')->nullable(); // Keterangan tambahan, bisa berisi detail perawatan atau lainnya
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perawatan');
    }
};
