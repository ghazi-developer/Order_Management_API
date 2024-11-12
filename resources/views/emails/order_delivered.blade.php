<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Received</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #636262;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0f0f0f;
            font-size: 24px;
        }
        p {
            color: #d4d4d4;
            line-height: 1.6;
        }
        .order-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* color: black; */
        }
        .order-details h2 {
            margin-top: 0;
        }
        .order-details p {
            margin: 8px 0;
    
        }
        .button {
            display: inline-block;
            background-color: #0bad31;
            color: #292727;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .font p{
            color :black;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Deliverd 🎉</h1>

        {{-- <p>Hello {{ $user->name }},</p> --}}
        <p>Thank you for your order!.</p>
        
        <div class="order-details">
            <div class="font">
                <h2>Order Summary:</h2>
                <p><strong>Order ID:</strong> {{ $order->id }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
                <p><strong>Product Name:</strong> {{ $order->name }}</p>
                <p><strong>Quantity:</strong> {{ $order->description }}</p>
                <p><strong>Total Price:</strong> ${{ number_format($order->price, 2) }}</p>
            </div>
        </div>

        <p>Your order will be shipped shortly, and you will receive another email when it has been dispatched. Meanwhile, feel free to browse our store and check out more exciting products!</p>
        
        <a href="{{ url('https://www.daraz.pk/#?') }}" class="button">Continue Shopping</a>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
