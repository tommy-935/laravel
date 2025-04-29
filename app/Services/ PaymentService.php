<?php

namespace App\Services;

use App\Mail\PaymentSuccessful;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;

class PaymentService
{
    protected $paypalService;
    protected $orderUser;
    protected $orderPayment;
    protected $orderPrice;

    public function __construct(
        
    ) {
        
    }

    public  static function successFul(Order $order, $session = null)
    {
        // token
        // $token = $this->genToken($order);
        // $order->token = $token;
        // mail
        Mail::to($order->orderUser->shipping_email)->send(new PaymentSuccessful($order));

        // queue
       // Mail::to($order->orderUser->shipping_email)->queue(new PaymentSuccessful($order));
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => [
                'redirect_url' => url('/checkout/key/' . $order->order_key),
                // 'session_url' => $session->url
            ]], 200);
    }
}