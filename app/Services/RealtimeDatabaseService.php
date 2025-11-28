<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RealtimeDatabaseService
{
    protected $databaseUrl;

    public function __construct()
    {
        $this->databaseUrl = rtrim(env('FIREBASE_DATABASE_URL'), '/');
    }

    public function getAll($path)
    {
        // Pastikan .json di akhir URL
        $url = "{$this->databaseUrl}/{$path}.json";
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            if (is_array($data)) {
                // Ubah keyed object (“1” => [data]) menjadi array numerik
                return array_values($data);
            }
        }

        return [];
    }
}
