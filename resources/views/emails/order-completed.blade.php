<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pesanan Selesai</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f7fb; margin:0; padding:24px;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,0.06);">
                    <tr>
                        <td style="padding:24px 24px 0 24px; text-align:center;">
                            <h1 style="margin:0; font-size:24px; color:#2f3c4c;">Pesanan Anda Selesai 🎉</h1>
                            <p style="margin:8px 0 0 0; color:#6b7280; font-size:14px;">Terima kasih telah memesan di Warkop Ijo</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 24px 0 24px;">
                            <table width="100%" style="border-collapse:collapse;">
                                <tr>
                                    <td style="padding:12px 0; color:#111827; font-weight:700;">Pesanan #{{ $order->id }}</td>
                                    <td style="padding:12px 0; text-align:right; color:#10b981; font-weight:700;">Rp {{ number_format($order->total_harga) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding:4px 0; color:#6b7280; font-size:14px;">Meja: {{ $order->nomor_meja ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding:4px 0; color:#6b7280; font-size:14px;">Status: Selesai</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding:12px 0; color:#6b7280; font-size:14px;">Pembayaran: {{ strtoupper($order->metode_pembayaran) }} • {{ $order->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum Lunas' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 24px 24px 24px;">
                            <div style="border:1px solid #e5e7eb; border-radius:10px; padding:16px; background:#f9fafb;">
                                <p style="margin:0 0 8px 0; color:#111827; font-weight:600;">Ringkasan Item</p>
                                <table width="100%" style="border-collapse:collapse;">
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td style="padding:6px 0; color:#374151; font-size:14px;">{{ $item->menu->nama ?? 'Item' }} x{{ $item->qty }}</td>
                                        <td style="padding:6px 0; text-align:right; color:#111827; font-size:14px; font-weight:600;">Rp {{ number_format($item->harga * $item->qty) }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 24px 24px 24px; text-align:center;">
                            <p style="margin:0 0 12px 0; color:#111827; font-weight:600;">Terima kasih, sampai jumpa lagi!</p>
                            <p style="margin:0; color:#6b7280; font-size:13px;">Warkop Ijo • Sistem Pemesanan</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
