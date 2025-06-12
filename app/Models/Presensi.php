<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
    'user_id',
    'tanggal_presensi',
    'jam_masuk',
    'jam_keluar',
    'lokasi_masuk',
    'lokasi_keluar',
];

    // Casting: tanggal sebagai date, jam masuk dan keluar sebagai format jam
    protected $casts = [
        'tanggal_presensi' => 'date',
        'jam_masuk' => 'datetime:H:i:s',
        'jam_keluar' => 'datetime:H:i:s',
    ];

    // Relasi ke user (karyawan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
