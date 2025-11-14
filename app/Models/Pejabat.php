<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'pejabat';

    // Nama primary key (sesuaikan dengan query MySQL di bawah)
    protected $primaryKey = 'id_pejabat';

    // Tentukan kolom yang bisa diisi (fillable)
    protected $fillable = [
        'jabatan',
        'deskripsi',
        'foto_path',
    ];

    // Matikan timestamps jika Anda tidak menggunakan kolom created_at dan updated_at
    // public $timestamps = false;
}