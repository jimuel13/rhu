<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SemaphoreService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('SEMAPHORE_API_KEY');
        $this->baseUrl = 'https://api.semaphore.co/api/v4/messages';
    }

    public function sendSMS($number, $message)
    {
        // Send a POST request to the Semaphore API
        $response = Http::post($this->baseUrl, [
            'apikey'=> $this->apiKey,
            'number'=> $number,
            'message'=> $message,
            // 'sendername'=> $senderName,
        ]);



        // Check if the request was successful
        if ($response->successful()) {
            return $response->json(); // Return the response data as an array
        } else {
            // Log the error or handle failure
            throw new \Exception('Failed to send SMS: ' . $response->body());
        }
    }
}
