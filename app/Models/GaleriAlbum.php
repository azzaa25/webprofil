<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GaleriAlbum extends Model
{
    use HasFactory;

    protected $table = 'galeri_album'; 
    protected $primaryKey = 'id_galeri';

    protected $fillable = [
        'nama_album',
        'cover_path',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Definisi relasi One-to-Many ke GaleriFoto
     */
    public function fotos(): HasMany
    {
        return $this->hasMany(GaleriFoto::class, 'album_id', 'id_galeri');
    }
    
    /**
     * Tentukan kolom untuk Route Model Binding
     */
    public function getRouteKeyName()
    {
        return 'id_galeri';
    }
}
