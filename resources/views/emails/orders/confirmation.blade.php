<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation - Casa Amaryllis</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #EC4899; margin: 0;">Order Confirmation</h1>
        </div>

        <p>Dear {{ $order->user->name }},</p>
        <p>Thank you for your order! Here are your order details:</p>

        <div style="background: #f8f8f8; padding: 15px; margin: 20px 0;">
            <h2 style="color: #333; margin-top: 0;">Order #{{ $order->id }}</h2>

            @foreach($order->items as $item)
            <div style="border-bottom: 1px solid #eee; padding: 10px 0;">
                <p style="margin: 5px 0;"><strong>{{ $item->product->name }}</strong></p>
                <p style="margin: 5px 0;">Quantity: {{ $item->quantity }}</p>
                <p style="margin: 5px 0;">Price: ${{ number_format($item->price, 2) }}</p>
            </div>
            @endforeach

            <div style="margin-top: 20px;">
                <p style="margin: 5px 0;"><strong>Total Amount: ${{ number_format($order->total_amount, 2) }}</strong></p>
                <p style="margin: 10px 0;"><strong>Shipping Address:</strong><br>
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zipcode }}</p>
            </div>
        </div>

        <p>If you have any questions about your order, please don't hesitate to contact us.</p>

        <p style="margin-top: 30px;">Best regards,<br>Casa Amaryllis Team</p>

        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #666; font-size: 12px;">
            <p>This is an automated email, please do not reply directly to this message.</p>
            <p>© {{ date('Y') }} Casa Amaryllis. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
