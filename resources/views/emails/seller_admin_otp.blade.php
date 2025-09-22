<!-- resources/views/emails/seller_admin_otp.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP for Email Verification</title>
</head>
<body>
    <h2>Your OTP is: {{ $otp }}</h2>
    <p>Please use this OTP to verify your email address. It will expire in 10 minutes.</p>
</body>
</html>
