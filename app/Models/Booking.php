<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_booking',
        'user_id',
        'telepon',
        'id_kosan',
        'id_kontrakan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_biaya',
        'status',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke kosan
    public function kosan()
    {
        return $this->belongsTo(Kosan::class, 'id_kosan');
    }

    // Relasi ke kontrakan
    public function kontrakan()
    {
        return $this->belongsTo(Kontrakan::class, 'id_kontrakan');
    }
}
