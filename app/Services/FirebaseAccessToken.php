<?php

namespace App\Services;

use Google\Client as GoogleClient;
use Exception;

class FirebaseAccessToken
{
    public static function get()
    {
        $path = base_path(env('FIREBASE_CREDENTIALS'));

        if (!file_exists($path)) {
            throw new Exception("🔥 Firebase credentials file not found at: {$path}");
        }

        $client = new GoogleClient();
        $client->setAuthConfig($path);
        $client->addScope("https://www.googleapis.com/auth/datastore");
        $client->addScope("https://www.googleapis.com/auth/cloud-platform");

        $token = $client->fetchAccessTokenWithAssertion();

        if (!isset($token['access_token'])) {
            throw new Exception("🚫 Failed to get Firebase access token: " . json_encode($token));
        }

        return $token['access_token'];
    }
}
