<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GaleriFoto extends Model
{
    use HasFactory;

    protected $table = 'galeri_foto'; 
    protected $primaryKey = 'id'; // Primary key tetap 'id'

    protected $fillable = [
        'album_id',
        'foto_path',
    ];

    /**
     * Definisi relasi BelongsTo ke GaleriAlbum
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(GaleriAlbum::class, 'album_id', 'id_galeri');
    }
}
