<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FirestoreService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = env('FIREBASE_FIRESTORE_BASE_URL');
        $this->token = FirebaseAccessToken::get();
    }

    public function create(string $collection, array $data)
    {
        $url = "{$this->baseUrl}/{$collection}";

        return Http::withToken($this->token)->post($url, [
            'fields' => $this->mapData($data)
        ])->json();
    }

    public function getAll(string $collection)
    {
        $url = "{$this->baseUrl}/{$collection}";
        return Http::withToken($this->token)->get($url)->json();
    }

    public function getDocument(string $collection, string $id)
    {
        $url = "{$this->baseUrl}/{$collection}/{$id}";
        return Http::withToken($this->token)->get($url)->json();
    }

    public function update(string $collection, string $id, array $data)
    {
        $mask = implode('&updateMask.fieldPaths=', array_keys($data));
        $url = "{$this->baseUrl}/{$collection}/{$id}?updateMask.fieldPaths={$mask}";

        return Http::withToken($this->token)->patch($url, [
            'fields' => $this->mapData($data)
        ])->json();
    }

    public function delete(string $collection, string $id)
    {
        $url = "{$this->baseUrl}/{$collection}/{$id}";
        return Http::withToken($this->token)->delete($url)->successful();
    }

    private function mapData(array $data)
    {
        $formatted = [];
        foreach ($data as $key => $value) {
            $formatted[$key] = ['stringValue' => (string) $value];
        }
        return $formatted;
    }
}
