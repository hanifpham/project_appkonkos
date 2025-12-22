<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kosan extends Model
{
    protected $table = 'kosans';

    protected $fillable = [
        'nama_kosan', 
        'alamat', 
        'kontak_kosan', 
        'harga_bulan',
        'gambar_kosan',
        'detail_kosan',
        'fasilitas_kosan',
        'fasilitas_umum',
        'peraturan_kosan', 
        'kamar_yang_tersedia', 
        'status', 
        'maps'
    ];
}
