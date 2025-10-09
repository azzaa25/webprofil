<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faq'; 
    protected $primaryKey = 'id_faq';

    protected $fillable = [
        'pertanyaan',
        'jawaban',
        'urutan',
    ];

    // Kita bisa mengatur urutan default saat mengambil data
    protected $casts = [
        'urutan' => 'integer',
    ];
}
