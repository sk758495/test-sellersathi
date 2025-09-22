<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset OTP</title>
    <style>
        /* You can add inline CSS or link external styles here */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #4CAF50;
        }
        .message {
            font-size: 16px;
            line-height: 1.5;
            color: #333333;
            margin-bottom: 20px;
        }
        .otp {
            display: inline-block;
            padding: 15px 25px;
            font-size: 24px;
            font-weight: bold;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }
        .footer {
            font-size: 14px;
            color: #999999;
            text-align: center;
        }
        
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .email-header img {
            max-width: 150px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ asset('https://gujjuemarket.com/user/images/gujju-logo.jpg') }}" alt="Gujju e-Market Logo">
        </div>
        <div class="header">
            Password Reset OTP
        </div>

        <div class="message">
            <p>We have received a request to reset your password. Please use the following OTP to proceed:</p>
            <div class="otp">{{ $otp }}</div>
            <p>This OTP is valid for 10 minutes. If you did not request a password reset, please ignore this email.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Gujju e-Market. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
