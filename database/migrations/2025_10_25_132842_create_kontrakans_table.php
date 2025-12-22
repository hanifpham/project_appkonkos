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
        Schema::create('kontrakans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kontrakan');
            $table->text('alamat');
            $table->string('kontak_kontrakan');
            $table->decimal('harga_tahun', 10, 2);
            $table->string('luas_kontrakan');
            $table->string('gambar_kontrakan');
            $table->text('detail_kontrakan');
            $table->string('jumlah_kamar');
            $table->text('fasilitas_kontrakan');
            $table->text('fasilitas_umum');
            $table->text('peraturan_kontrakan');
            $table->enum('status', ['tersedia', 'tidak tersedia', 'batal'])->default('tersedia');
            $table->text('maps')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kosan');
    }
};
