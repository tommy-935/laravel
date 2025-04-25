<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Mail\PaymentSuccessful;
use App\Models\SoftToken;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:paypal,stripe,apple_pay',
            'shipping_address' => 'required_if:same_as_billing,false',
            'billing_address' => 'required',
        ]);

        $order = $this->createOrder($request);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order creation failed: order is null',
            ], 500);
        }

        switch ($request->payment_method) {
            case 'paypal':
                return $this->processPayPalPayment($order);
            case 'stripe':
                return $this->processStripePayment($order);
            case 'apple_pay':
                return $this->processApplePayPayment($order);
            default:
                return back()->with('error', 'not supported');
        }
    }

    public function getCheckoutOrderInfo(Request $request)
    {
        $data = Order::getCheckoutOrderInfo($request->key);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $data
        ]);
    }

    protected function createOrder(Request $request)
    {
        error_log(print_r('$data', true) . "\r\n", 3, '/Volumes/dev/www/debug.log');

        $cartUuid = $request->cookie('hash_uuid');
        $cartItems = CartItem::with('product')
            ->where('session_id', $cartUuid)
            ->get();
        if ($cartItems->isEmpty()) {
            /*
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.',
            ], 422);
            */
        }
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $uid = Auth::id() ?? 0;
        
        try{
            DB::transaction(function() use ($request, $total, $uid, &$order, $cartItems, $cartUuid) {
                $billing_address = $request->billing_address;
                $shipping_address = $request->shipping_address;
                $order_key = Str::random(32);
                $expired_at = '2999-12-31 00:00:00';
                error_log(print_r('ooo$5555', true) . "\r\n", 3, '/Volumes/dev/www/debug.log');
                try{
                    $order = Order::create([
                        'order_num' => 'NUM-' . Str::upper(Str::random(10)),
                        'order_key' => $order_key,
                        'status' => 'pending',
                        'created_by' => $uid,
                        'updated_by' => $uid,
    
                    ]);
                
                
                error_log(print_r('ooo$9999', true) . "\r\n", 3, '/Volumes/dev/www/debug.log');
                error_log(print_r($request, true) . "\r\n", 3, '/Volumes/dev/www/debug.log');

                $order->price()->create([
                    'sub_total' => $total,
                    'total' => $total,
                ]);

                /*
                $cartItems->map(function ($item) use ($order) {
                    $order->product()->create([
                        'product_id' => $item->product->id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'qty' => $item->quantity,
                        'item_price' => $item->product->price * $item->quantity,
                    ]);
                });
                */
                

                $order->orderUser()->create([
                    'user_id' => $uid,
                    'session_id' => $cartUuid,
                    'billing_country' => $billing_address['country'],
                    'billing_state' => $billing_address['state'],
                    'billing_city' => $billing_address['city'],
                    'billing_first_name' => $billing_address['first_name'],
                    'billing_last_name' => $billing_address['last_name'],
                    'billing_email' => $billing_address['email'],
                    'billing_address1' => $billing_address['address1'],
                    'billing_address2' => $billing_address['address2'],
                    'billing_phone' => $billing_address['phone'],
                    'billing_zip_code' => $billing_address['phone'],

                    'shipping_first_name' => $shipping_address['first_name'],
                    'shipping_last_name' => $shipping_address['last_name'],
                    'shipping_email' => $shipping_address['email'],
                    'shipping_address1' => $shipping_address['address1'],
                    'shipping_address2' => $shipping_address['address2'],
                    'shipping_city' => $shipping_address['city'],
                    'shipping_state' => $shipping_address['state'],
                    'shipping_country' => $shipping_address['country'],
                    'shipping_phone' => $shipping_address['phone'],
                    'shipping_zip_code' => $shipping_address['zip_code'],
                ]);

                $token = Str::random(32);
                $order->softToken()->create([
                    'token' => $token,
                    'expired_at' => $expired_at,
                    'created_by' => $uid,
                    'updated_by' => $uid,
                    'website_num' => 1,
                    'email' => $shipping_address['email'],
                ]);
            }catch (\Throwable $e) {
                    error_log("内部异常：" . $e->getMessage() . "\n", 3, '/Volumes/dev/www/debug.log');
                    throw $e; // 向外抛出事务终止
                }
                error_log(print_r($order, true) . "\r\n", 3, '/Volumes/dev/www/debug.log');
                error_log(print_r('66666', true) . "\r\n", 3, '/Volumes/dev/www/debug.log');
            
            });
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Order creation failed: ' . $e->getMessage(),
            ], 500);
        }
        

        /*
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }
            */

        
        CartItem::where('user_id', Auth::id())->delete();
        CartItem::where('session_id', $cartUuid)->delete();

        return $order;
    }

    protected function processPayPalPayment(Order $order)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('checkout.success'),
                "cancel_url" => route('checkout.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $order->total_amount
                    ],
                    "reference_id" => $order->order_number,
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'paypal',
                'amount' => $order->total_amount,
                'status' => 'pending',
                'transaction_id' => $response['id'],
            ]);

            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('checkout.cancel')->with('error', 'PayPal payment failed.');
    }

    protected function processStripePayment(Order $order)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Order #' . $order->order_num,
                    ],
                    'unit_amount' => $order->orderPrice->total * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'metadata' => [
                'order_number' => $order->order_num,
            ],
        ]);

        OrderPayment::create([
            'order_id' => $order->id,
            'order_num' => $order->order_num,
            'paid_date' => $session->created,
            'payment_method' => 'stripe',
            'currency' => $session->currency,
            'amount' => $order->total_amount,
            'status' => 'pending',
            'transaction_id' => $session->id,
        ]);

        $this->successFul($order);

        // return redirect()->away($session->url);
        return response()->json([
            'url' => $session->url
        ]);
    }

    protected function genToken(Order $order)
    {
        $token = Str::random(32);
        $uid = Auth::id() ?? 0;
        try{
            SoftToken::create([
                'token' => $token,
                'expired_at' => now()->addMinutes(5),
                'created_by' => $uid,
                'updated_by' => $uid,
                'website_num' => 1,
                'email' => $order->orderUser->shipping_email,
            ]);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
        
        return $token;
    }

    protected function successFul(Order $order)
    {
        // token
        // $token = $this->genToken($order);
        // $order->token = $token;
        // mail
        Mail::to($order->orderUser->shipping_email)->send(new PaymentSuccessful($order));

        // queue
       // Mail::to($order->orderUser->shipping_email)->queue(new PaymentSuccessful($order));
    }

    protected function processApplePayPayment(Order $order)
    {
        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'apple_pay',
            'amount' => $order->total_amount,
            'status' => 'completed',
            'transaction_id' => 'apple_pay_' . Str::random(10),
        ]);

        $order->update(['status' => 'completed']);

        return redirect()->route('checkout.success');
    }

    public function checkoutSuccess(Request $request)
    {
        if ($request->has('session_id')) {
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = StripeSession::retrieve($request->session_id);

            $payment = Payment::where('transaction_id', $session->id)->first();
            if ($payment) {
                $payment->update([
                    'status' => 'completed',
                    'details' => $session->toArray(),
                ]);

                $payment->order->update(['status' => 'completed']);
            }
        }

        return view('checkout.success');
    }

    public function checkoutCancel()
    {
        return view('checkout.cancel');
    }
}