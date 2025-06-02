<?php

namespace App\Services;

use GuzzleHttp\Client;

class AIService
{
    private $client;
    private $apiUrl;
    private $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = env('IBM_WATSONX_API_URL');
        $this->apiKey = env('IBM_WATSONX_API_KEY');
    }

    private function generateAccessToken()
    {
        $tokenUrl = 'https://iam.cloud.ibm.com/identity/token';
        $response = $this->client->post($tokenUrl, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type' => 'urn:ibm:params:oauth:grant-type:apikey',
                'apikey' => $this->apiKey,
            ],
        ]);

        $tokenResponse = json_decode($response->getBody()->getContents(), true);
        return $tokenResponse['access_token'];
    }

    public function generateResponse($message)
    {
        $accessToken = $this->generateAccessToken();
        $projectId = env('IBM_WATSONX_PROJECT_ID');
        $modelId = env('IBM_WATSONX_MODEL_ID');
        $response = $this->client->post($this->apiUrl, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'json' => [
                'project_id' => $projectId,
                'model_id' => $modelId,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $message,
                    ],
                ],
            ],
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);
        return $responseData;
    }
}
