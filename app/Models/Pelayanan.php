<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
    use HasFactory;

    protected $table = 'pelayanan'; 
    protected $primaryKey = 'id_pelayanan';

    protected $fillable = [
        'nama_pelayanan',
        'deskripsi',
        'persyaratan',
        'proses',
        'waktu_layanan',
        'keterangan',
        'dibuat_oleh',
        'tanggal_publikasi',
    ];

    protected $casts = [
        'persyaratan' => 'array', // Mengkonversi JSON ke array PHP otomatis
        'proses' => 'array',
        'tanggal_publikasi' => 'date',
    ];
}
