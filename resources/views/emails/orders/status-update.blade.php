<?php
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Status Update - Casa Amaryllis</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #EC4899; text-align: center;">Order Status Update</h1>
        <p>Dear {{ $order->user->name }},</p>
        <p>Your order #{{ $order->id }} status has been updated to: <strong>{{ ucfirst($order->status) }}</strong></p>
        
        @if($order->status === 'processing')
            <p>We are now processing your order and will prepare it for shipping.</p>
        @elseif($order->status === 'shipped')
            <p>Your order has been shipped and is on its way to you!</p>
        @elseif($order->status === 'completed')
            <p>Your order has been delivered. Thank you for shopping with us!</p>
        @elseif($order->status === 'cancelled')
            <p>Your order has been cancelled. If you have any questions, please contact us.</p>
        @endif

        <div style="margin-top: 20px; padding: 15px; background-color: #f8f8f8;">
            <h3 style="margin-top: 0;">Order Details:</h3>
            <p>Order Total: ${{ number_format($order->total_amount, 2) }}</p>
            <p>Shipping Address:<br>
            {{ $order->shipping_address }}<br>
            {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zipcode }}</p>
        </div>

        <p>If you have any questions, please don't hesitate to contact us.</p>
        <p>Best regards,<br>Casa Amaryllis Team</p>
    </div>
</body>
</html>
