<?php

namespace App\Http\Controllers;

use App\Services\PaypalService;
use Illuminate\Http\Request;
use App\Models\Order;

class PaypalController extends Controller
{
    protected $paypal;

    public function __construct(PaypalService $paypal)
    {
        $this->paypal = $paypal;
    }

    public function capture(Request $request)
    {
        $orderId = $request->input('orderID');

        if (!$orderId) {
            return response()->json(['error' => 'Empty ID'], 400);
        }

        $order = $this->paypal->captureOrder($orderId);

        if (isset($order['status']) && $order['status'] === 'COMPLETED') {
            $this_order = Order::select('order_key')->where('order_num', $order->order_num)->first();
            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => [
                    'redirect_url' => url('/checkout/key/' . $this_order->order_key)
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'messge' => 'verify failed',
                'data' => []
            ], 400);
        }
    }
}
