<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuTamuController extends Controller
{
    public function index()
    {
        return view('buku-tamu.index'); // nanti buat view-nya
    }
}
