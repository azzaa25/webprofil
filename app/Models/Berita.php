<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita'; 
    protected $primaryKey = 'id_berita'; 

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'penulis',
        'kategori',
        'tanggal_publikasi',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
    ];

    // 👇 Tambahkan ini biar route pakai id_berita, bukan "beritum"
    public function getRouteKeyName()
    {
        return 'id_berita';
    }
}
