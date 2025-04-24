<?php

namespace App\Http\Controllers;

use App\Models\OrderPayment;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function handlePayPalWebhook(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        
        $webhookEvent = $provider->verifyWebHookSignature($request->all());

        if ($webhookEvent['event_type'] === 'PAYMENT.CAPTURE.COMPLETED') {
            $transactionId = $webhookEvent['resource']['id'];
            
            $payment = Payment::where('transaction_id', $transactionId)->first();
            if ($payment) {
                $payment->update([
                    'status' => 'completed',
                    'details' => $webhookEvent,
                ]);
                
                $payment->order->update(['status' => 'completed']);
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Handle Stripe webhooks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleStripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                
                $payment = OrderPayment::where('transaction_id', $session->id)->first();
                if ($payment) {
                    $payment->update([
                        'status' => 'completed',
                        'details' => json_decode(json_encode($session)),
                    ]);
                    
                    $payment->order->update(['status' => 'completed']);
                }
                break;
        }

        return response()->json(['success' => true]);
    }
}