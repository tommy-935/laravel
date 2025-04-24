// app/Http/Controllers/CookieConsentController.php
<?php

namespace App\Http\Controllers;

use App\Services\CookieConsentService;
use Illuminate\Http\Request;

class CookieConsentController extends Controller
{
    protected $cookieService;

    public function __construct(CookieConsentService $cookieService)
    {
        $this->cookieService = $cookieService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'necessary' => 'required|boolean',
            'analytics' => 'required|boolean',
            'marketing' => 'required|boolean',
        ]);

        $this->cookieService->setConsent($validated);

        return response()->json([
            'success' => true,
            'consent' => $validated
        ]);
    }

    public function getConsent()
    {
        return response()->json([
            'consent' => $this->cookieService->getConsent()
        ]);
    }
}