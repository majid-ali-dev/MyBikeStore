<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>All Delivered Orders Report - {{ now()->format('F d, Y') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8px;
            margin: 10px;
            line-height: 1.2;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
            color: #333;
            font-weight: bold;
        }

        .header p {
            font-size: 10px;
            margin: 5px 0 0 0;
            color: #666;
        }

        .summary-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 3px;
        }

        .summary-item {
            display: inline-block;
            margin-right: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #343a40;
            color: white;
            padding: 6px 4px;
            text-align: left;
            font-weight: bold;
            font-size: 7px;
            border: 1px solid #dee2e6;
        }

        td {
            padding: 5px 4px;
            border: 1px solid #dee2e6;
            vertical-align: top;
            font-size: 7px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .amount {
            font-weight: bold;
            color: #28a745;
        }

        .status-paid {
            color: #28a745;
            font-weight: bold;
        }

        .status-pending {
            color: #dc3545;
            font-weight: bold;
        }

        .order-id {
            font-weight: bold;
            color: #007bff;
        }

        .items-details {
            max-width: 150px;
            word-wrap: break-word;
            font-size: 6px;
        }

        .address {
            max-width: 120px;
            word-wrap: break-word;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 7px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }

        .page-number {
            position: fixed;
            bottom: 10px;
            right: 10px;
            font-size: 7px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>🚚 All Delivered Orders Report</h1>
        <p>Generated on: {{ now()->format('F d, Y \a\t H:i A') }}</p>
    </div>

    @if ($ordersData->isEmpty())
        <div class="summary-box">
            <p style="text-align: center; font-size: 12px; color: #dc3545;">
                ❌ No delivered orders found in the system.
            </p>
        </div>
    @else
        <div class="summary-box">
            <span class="summary-item">📊 Total Orders: {{ $ordersData->count() }}</span>
            <span class="summary-item">💰 Total Revenue: ${{ number_format($ordersData->sum('total_amount'), 2) }}</span>
            <span class="summary-item">📦 Total Items: {{ $ordersData->sum('items_count') }}</span>
            <span class="summary-item">✅ All Status: Delivered</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 6%;">Order ID</th>
                    <th style="width: 12%;">Customer Info</th>
                    <th style="width: 8%;">Amount</th>
                    <th style="width: 7%;">Payment</th>
                    <th style="width: 9%;">Delivery Date</th>
                    <th style="width: 8%;">Bike Brand</th>
                    <th style="width: 5%;">Items</th>
                    <th style="width: 15%;">Items Details</th>
                    <th style="width: 10%;">Categories</th>
                    <th style="width: 15%;">Shipping Address</th>
                    <th style="width: 5%;">Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ordersData as $order)
                    <tr>
                        <td class="text-center">
                            <span class="order-id">#{{ $order['id'] }}</span>
                        </td>

                        <td>
                            <strong>{{ $order['customer_name'] }}</strong><br>
                            <small style="color: #666;">{{ $order['customer_email'] }}</small>
                        </td>

                        <td class="text-right">
                            <span class="amount">${{ number_format($order['total_amount'], 2) }}</span>
                        </td>

                        <td class="text-center">
                            <span class="{{ $order['payment_status'] === 'Paid' ? 'status-paid' : 'status-pending' }}">
                                {{ $order['payment_status'] === 'Paid' ? '✅' : '⏳' }} {{ $order['payment_status'] }}
                            </span>
                        </td>

                        <td class="text-center">
                            <strong>{{ $order['delivery_date'] }}</strong><br>
                            <small>{{ $order['delivery_time'] }}</small>
                        </td>

                        <td class="text-center">
                            <span
                                style="background: #6c757d; color: white; padding: 2px 6px; border-radius: 3px; font-size: 6px;">
                                {{ $order['brand_info'] }}
                            </span>
                        </td>

                        <td class="text-center">
                            <span
                                style="background: #007bff; color: white; padding: 2px 6px; border-radius: 10px; font-size: 6px;">
                                {{ $order['items_count'] }}
                            </span>
                        </td>

                        <td class="items-details">
                            {{ $order['items_details'] }}
                        </td>

                        <td>
                            <small>{{ $order['categories'] }}</small>
                        </td>

                        <td class="address">
                            {{ $order['shipping_address'] }}
                        </td>

                        <td>
                            <small>{{ Str::limit($order['notes'], 30) }}</small>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>
                📄 This report contains {{ $ordersData->count() }} delivered orders |
                💼 Total Business Value: ${{ number_format($ordersData->sum('total_amount'), 2) }} |
                🏪 MyBikeStore Management System
            </p>
            <p style="margin-top: 5px;">
                Report generated automatically on {{ now()->format('l, F d, Y \a\t H:i:s A') }}
            </p>
        </div>
    @endif

    <div class="page-number">
        Page <span class="pagenum"></span>
    </div>
</body>

</html>
