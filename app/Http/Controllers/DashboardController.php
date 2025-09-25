<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalPengunjung' => 100,
            'beritaAktif' => 73,
        ]);
    }
}
