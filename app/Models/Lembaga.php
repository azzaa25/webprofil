<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembaga extends Model
{
    use HasFactory;

    protected $table = 'lembaga'; // Asumsi nama tabel plural

    // TAMBAHKAN BARIS INI: Definisikan primary key yang benar
    protected $primaryKey = 'id_lembaga';

    // PERHATIAN: Tambahkan primary key ke fillable jika Anda menggunakannya (meskipun biasanya tidak diperlukan di sini karena id diisi otomatis)
    protected $fillable = [
        'nama',
        'deskripsi',
    ];
}