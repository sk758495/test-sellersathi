<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP for Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .email-header img {
            max-width: 150px;
        }

        .email-body {
            font-size: 16px;
            color: #333;
            line-height: 1.5;
        }

        .otp {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ asset('https://gujjuemarket.com/user/images/gujju-logo.jpg') }}" alt="Gujju e-Market Logo">
        </div>

        <div class="email-body">
            <h2>Your OTP for Email Verification</h2>
            <p>Thank you for registering with us! To verify your email address, please use the OTP below:</p>
            <p class="otp">{{ $otp }}</p>
            <p>This OTP will expire in 10 minutes. If you did not request this, please ignore this email.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Gujju e-Market. All rights reserved.</p>
            <p>If you are having trouble, please contact <a href="mailto:support@gujjumarket.com">support@gujjumarket.com</a></p>
        </div>
    </div>
</body>

</html>
