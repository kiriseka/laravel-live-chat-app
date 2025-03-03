<?php

namespace App\Services;

use GuzzleHttp\Client;

class GeminiService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function sendMessage($message)
    {
        $response = $this->client->post('https://api.gemini.ai/v1/chat', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'message' => $message,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
