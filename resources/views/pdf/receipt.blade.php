<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Order Receipt</h2>
    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₱{{ number_format($item->price, 2) }}</td>
                <td>₱{{ number_format($item->quantity * $item->price, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <p><strong>Total:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
</body>
</html>
