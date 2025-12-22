<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontrakan extends Model
{
    protected $table = 'kontrakans';
    protected $fillable = [
        'nama_kontrakan',
        'alamat',
        'luas_kontrakan',
        'kontak_kontrakan',
        'harga_tahun',
        'gambar_kontrakan',
        'detail_kontrakan',
        'fasilitas_kontrakan',
        'fasilitas_umum',
        'peraturan_kontrakan',
        'jumlah_kamar',
        'status',
        'maps'
    ];
}
