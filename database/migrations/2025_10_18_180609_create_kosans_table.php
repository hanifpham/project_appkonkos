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
       Schema::create('kosans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kosan');
            $table->text('alamat');
            $table->string('kontak_kosan');
            $table->decimal('harga_bulan', 10, 2);
            $table->string('gambar_kosan');
            $table->text('detail_kosan');
            $table->text('fasilitas_kosan');
            $table->text('fasilitas_umum');
            $table->text('peraturan_kosan');
            $table->string('kamar_yang_tersedia');
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
