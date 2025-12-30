<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background-color: #499587;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 30px;
        }
        .content h2 {
            color: #499587;
            font-size: 22px;
            margin-bottom: 20px;
        }
        .content p {
            margin-bottom: 15px;
            font-size: 16px;
        }
        .button {
            display: inline-block;
            background-color: #499587;
            color: white !important;
            padding: 14px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .button:hover {
            background-color: #3a7a6e;
        }
        .footer {
            background-color: #f8f8f8;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #e0e0e0;
        }
        .info-box {
            background-color: #f9f9f9;
            border-left: 4px solid #499587;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Reset Password</h1>
        </div>
        
        <div class="content">
            <h2>Halo, {{ $user->name }}!</h2>
            
            <p>Kami menerima permintaan untuk mereset password akun Anda di Warkop Ijo.</p>
            
            <p>Klik tombol di bawah ini untuk mereset password Anda:</p>
            
            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="button">Reset Password</a>
            </div>
            
            <div class="info-box">
                <p style="margin: 0;"><strong>Catatan:</strong></p>
                <p style="margin: 5px 0 0 0;">Jika Anda tidak meminta reset password, abaikan email ini. Link reset password akan kadaluarsa setelah beberapa waktu.</p>
            </div>
            
            <p>Atau copy dan paste link berikut di browser Anda:</p>
            <p style="word-break: break-all; color: #499587;">{{ $resetUrl }}</p>
        </div>
        
        <div class="footer">
            <p>Terima kasih telah menjadi bagian dari Warkop Ijo!</p>
            <p>&copy; {{ date('Y') }} Warkop Ijo. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
