<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaypalService
{
    protected $clientId;
    protected $clientSecret;
    protected $baseUrl;

    public function __construct()
    {
        if(config('paypal.mode') == 'live'){
            $this->clientId = config('paypal.client_id');
            $this->clientSecret = config('paypal.client_secret');
        }else{
            $this->clientId = config('paypal.sandbox_client_id');
            $this->clientSecret = config('paypal.sandbox_client_secret');
        }
        
        $this->baseUrl = config('paypal.mode') === 'live'
            ? 'https://api.paypal.com'
            : 'https://api.sandbox.paypal.com';
        
    }

    public function getAccessToken()
    {
        $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
            ->asForm()
            ->post($this->baseUrl . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

        return $response->json('access_token');
    }

    public function captureOrder($orderId)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
        ->withBody('', 'application/json')
            ->post($this->baseUrl . "/v2/checkout/orders/{$orderId}/capture");

        return $response->json();
    }

    public function getOrder($orderId)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->get($this->baseUrl . "/v2/checkout/orders/{$orderId}");

        return $response->json();
    }
}
