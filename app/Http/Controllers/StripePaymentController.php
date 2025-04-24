<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Log;

class StripePaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        // Validate the request
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'currency' => 'sometimes|string|size:3',
        ]);

        try {
            // Set your Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));
            
            // Create a PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100, // Stripe amounts are in cents
                'currency' => $request->currency ?? 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                // You can add more options here
                // 'metadata' => ['order_id' => '123'],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'paymentIntentId' => $paymentIntent->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Stripe Payment Intent Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}