<?php

namespace App\Services;

class CookieConsentService
{
    const COOKIE_NAME = 'gdpr_consent';
    const COOKIE_LIFETIME = 365 * 24 * 60; // 1 year in minutes

    public function getConsent()
    {
        if (!isset($_COOKIE[self::COOKIE_NAME])) {
            return null;
        }

        $data = json_decode($_COOKIE[self::COOKIE_NAME], true);
        
        // Verify signature to prevent tampering
        if (!$this->verifySignature($data)) {
            return null;
        }

        return $data;
    }

    public function setConsent(array $categories)
    {
        $consentData = [
            'version' => '1.0',
            'timestamp' => now()->toIso8601String(),
            'categories' => $categories,
            'user_agent' => hash('sha256', request()->userAgent()) // anonymized
        ];

        $consentData['signature'] = $this->createSignature($consentData);

        setcookie(
            self::COOKIE_NAME,
            json_encode($consentData),
            time() + (self::COOKIE_LIFETIME * 60),
            '/',
            config('session.domain'),
            true,  // secure
            false  // httpOnly not needed for frontend access
        );
    }

    private function createSignature(array $data)
    {
        return hash_hmac(
            'sha256',
            json_encode($data),
            config('app.key')
        );
    }

    private function verifySignature(array $data)
    {
        if (!isset($data['signature'])) {
            return false;
        }

        $signature = $data['signature'];
        unset($data['signature']);

        return hash_equals(
            $this->createSignature($data),
            $signature
        );
    }
}