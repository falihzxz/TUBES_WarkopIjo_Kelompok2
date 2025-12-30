<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Receipt #{{ $order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #499587;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #499587;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 13px;
        }
        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .receipt-info div {
            flex: 1;
        }
        .receipt-info label {
            color: #999;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 3px;
        }
        .receipt-info span {
            color: #333;
            font-weight: bold;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .items-table th {
            background-color: #f5f5f5;
            color: #333;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        .items-table td.qty {
            text-align: center;
        }
        .items-table td.price {
            text-align: right;
        }
        .items-table td.subtotal {
            text-align: right;
            font-weight: bold;
            color: #499587;
        }
        .summary {
            margin-bottom: 20px;
            border-top: 2px solid #ddd;
            padding-top: 15px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 13px;
        }
        .summary-row.total {
            font-size: 18px;
            font-weight: bold;
            color: #499587;
            border-top: 2px solid #499587;
            padding-top: 10px;
        }
        .footer {
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            color: #999;
            font-size: 11px;
        }
        .footer p {
            margin-bottom: 5px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-menunggu {
            background-color: #fef3c7;
            color: #b45309;
        }
        .status-diproses {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        .status-siap {
            background-color: #d1fae5;
            color: #059669;
        }
        .status-selesai {
            background-color: #d1f5f0;
            color: #499587;
        }
        .payment-info {
            background-color: #f9fafb;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .payment-info label {
            color: #999;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            display: block;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🧾 RECEIPT</h1>
            <p>Warkop Tubes</p>
        </div>

        <!-- Receipt Info -->
        <div class="receipt-info">
            <div>
                <label>No. Pesanan</label>
                <span>#{{ $order->id }}</span>
            </div>
            <div>
                <label>Meja</label>
                <span>{{ $order->nomor_meja }}</span>
            </div>
            <div>
                <label>Tanggal</label>
                <span>{{ $order->created_at->format('d/m/Y') }}</span>
            </div>
            <div>
                <label>Jam</label>
                <span>{{ $order->created_at->format('H:i') }}</span>
            </div>
        </div>

        <!-- Status -->
        <div style="text-align: center; margin-bottom: 20px;">
            <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Item</th>
                    <th style="width: 15%;">Qty</th>
                    <th style="width: 20%;">Harga</th>
                    <th style="width: 15%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->menu->nama }}</td>
                    <td class="qty">{{ $item->qty }}</td>
                    <td class="price">Rp {{ number_format($item->harga) }}</td>
                    <td class="subtotal">Rp {{ number_format($item->harga * $item->qty) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Payment Info -->
        <div class="payment-info">
            <label>Metode Pembayaran</label>
            <span style="font-weight: bold; color: #333;">{{ strtoupper($order->metode_pembayaran) }}</span>
            @if(isset($order->status_pembayaran))
                <div style="margin-top: 8px;">
                    <label>Status Pembayaran</label>
                    <span style="font-weight: bold; color: #333;">{{ str_replace('_', ' ', ucfirst($order->status_pembayaran)) }}</span>
                </div>
            @endif
        </div>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($order->total_harga) }}</span>
            </div>
            <div class="summary-row">
                <span>Pajak (0%)</span>
                <span>Rp 0</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span>Rp {{ number_format($order->total_harga) }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah berkunjung ke Warkop Tubes!</p>
            <p>Selamat menikmati</p>
            <p style="margin-top: 10px;">{{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
