<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';
    
    // 1. Definisikan primary key yang benar
    protected $primaryKey = 'id_profil'; 

    protected $fillable = [
        // 2. Gunakan nama primary key yang benar di fillable
        'id_profil', 
        'visi',
        'misi',
        'sejarah',
        'struktur_path',
    ];

    protected $hidden = [
        
    ];

    protected $casts = [
        
    ];
}