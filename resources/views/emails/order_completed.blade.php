<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Ready for Pickup - MyBikeStore</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            line-height: 1.5;
        }

        .email-container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: #28a745;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .content {
            padding: 25px;
        }

        .order-info {
            background: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #28a745;
        }

        .order-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
        }

        .payment-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
        }

        .paid-amount {
            background: #e8f5e9;
            color: #28a745;
        }

        .remaining-amount {
            background: #ffebee;
            color: #d32f2f;
        }

        .pickup-box {
            background: #007bff;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }

        .items-summary {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 14px;
        }

        .call-button {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 15px 0;
        }

        .footer {
            background: #343a40;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>✅ Your Custom Bike is Ready!</h1>
        </div>

        <div class="content">
            <p><strong>Dear {{ $customerName }},</strong></p>

            <p>We're pleased to inform you that your custom bike built with selected parts is now ready for collection.
            </p>

            <div class="order-info">
                <div class="order-row">
                    <span><strong>Order #:</strong></span>
                    <span>#{{ $order->id }}</span>
                </div>
                <div class="order-row">
                    <span><strong>Total Amount:</strong></span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="order-row">
                    <span><strong>Payment Status:</strong></span>
                    <span>
                        <span class="payment-status paid-amount">40% Paid
                            (${{ number_format($order->total_amount * 0.4, 2) }})</span>
                        <span class="payment-status remaining-amount">60% Due
                            (${{ number_format($order->total_amount * 0.6, 2) }})</span>
                    </span>
                </div>
            </div>

            <div class="items-summary">
                <strong>Your Selected Parts:</strong><br>
                @foreach ($orderItems as $item)
                    • {{ $item->part->name }} ({{ $item->quantity }}x)<br>
                @endforeach
            </div>

            <div class="pickup-box">
                <h3 style="margin-top:0;">🏍️ Ready for Pickup</h3>
                <p>Please complete your remaining payment of
                    <strong>${{ number_format($order->total_amount * 0.6, 2) }}</strong> when collecting your bike.</p>
                <p><strong>Store Location:</strong> 123 Motorcycle Avenue, Karachi</p>
            </div>

            <p><strong>Important Notes:</strong></p>
            <ul style="margin:10px 0; padding-left:20px;">
                <li>Please bring your payment receipt for the 40% deposit</li>
                <li>The remaining 60% payment is due upon collection</li>
                <li>Valid ID required for pickup verification</li>
            </ul>

            <div style="text-align:center;">
                <a href="tel:+923001234567" class="call-button">Contact Store</a>
            </div>

            <p>We appreciate your trust in MyBikeStore and look forward to seeing you soon!</p>

            <p>Best regards,<br><strong>MyBikeStore Team</strong></p>
        </div>

        <div class="footer">
            <p>MyBikeStore | Karachi | +92 300 123 4567</p>
        </div>
    </div>
</body>

</html>
