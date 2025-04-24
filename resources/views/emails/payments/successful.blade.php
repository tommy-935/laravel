@component('mail::message')
# Payment Successful

Hello {{ $order->orderUser->shipping_last_name }},

Your payment for order #{{ $order->id }} has been successfully processed.

Your Plugin () Token is {{ $order->orderUser->token }}

@component('mail::panel')
**Order Details:**  
Amount: \${{ number_format($order->amount, 2) }}  
Date: {{ $order->created_at->format('F j, Y') }}  
@endcomponent

@component('mail::button', ['url' => route('orders.show', $order->id)])
View Your Order
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent