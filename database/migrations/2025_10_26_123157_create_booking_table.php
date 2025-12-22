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
        Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->string('id_booking')->unique();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('telepon')->nullable();
        $table->foreignId('id_kosan')->nullable()->constrained('kosans')->onDelete('cascade');
        $table->foreignId('id_kontrakan')->nullable()->constrained('kontrakans')->onDelete('cascade');
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai');
        $table->decimal('jumlah_biaya', 12, 2);
        $table->enum('status', ['Pending', 'Diterima', 'Ditolak'])->default('Pending');
        $table->timestamps();
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
