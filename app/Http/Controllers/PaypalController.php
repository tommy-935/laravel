<?php

namespace App\Http\Controllers;

use App\Services\PaypalService;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderPayment;
use Carbon\Carbon;
use App\Services\PaymentService;

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

        $order = $this->paypal->getOrder($orderId);
        // error_log(print_r($order, true) . "\r\n", 3, '/Volumes/dev/www/debug.log');

        if (isset($order['status']) && $order['status'] === 'COMPLETED') {
            $order_num = $order['purchase_units'][0]['custom_id'];
            $this_order = Order::with(['orderUser', 'orderSoftToken', 'price'])->select('order_key', 'id', 'created_at')->where('order_num', $order_num)->first();

            if(!$this_order) {
                return response()->json(['error' => 'Order not found'], 404);
            }
            OrderPayment::where(['order_id' => $this_order->id])->update([
                'paid_date' => Carbon::parse($order['create_time'])->format('Y-m-d H:i:s'),
                'status' => 'processing',
                'transaction_id' => $order['id'],
            ]);
    
            return PaymentService::successFul($this_order);
            // return response()->json([
            //     'success' => true,
            //     'message' => 'success',
            //     'data' => [
            //         'redirect_url' => url('/checkout/key/' . $this_order->order_key)
            //     ]
            // ]);
        } else {
            return response()->json([
                'success' => false,
                'messge' => 'verify failed',
                'data' => []
            ], 400);
        }
    }
}
