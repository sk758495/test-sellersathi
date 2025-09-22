<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        /* General email styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .email-header img {
            max-width: 150px;
            margin: 0 auto;
        }

        h1 {
            color: #2c3e50;
            font-size: 26px;
            text-align: center;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        h3 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 10px;
        }

        /* Table for order details */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        td {
            background-color: #fafafa;
        }

        .total-amount {
            font-size: 18px;
            font-weight: bold;
            color: #e74c3c;
            margin-top: 20px;
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #7f8c8d;
        }

        .footer p {
            margin: 5px 0;
        }

        /* Responsive Design */
        @media only screen and (max-width: 600px) {
            .email-container {
                padding: 15px;
            }

            h1 {
                font-size: 22px;
            }

            h3 {
                font-size: 18px;
            }

            .total-amount {
                font-size: 16px;
            }

            table, th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header with logo -->
        <div class="email-header">
            <img src="{{ url('https://gujjuemarket.com/user/images/gujju-logo.jpg') }}" alt="Gujju e-Market Logo">
        </div>
        <h1>Thank You!</h1>
        <p>Dear {{ $name }},</p>
        <p>Thank you for reaching out to us at Gujjuemarket. We appreciate you contacting us!</p>
        <p>We have received your message:</p>
        <blockquote>{{ $messageContent }}</blockquote>
        <p>Our team will get back to you as soon as possible.</p>
        <p>Best Regards,</p>
        <p><strong>Gujjuemarket Team</strong></p>
        <div class="footer">
            <p>If you have any questions, feel free to contact us at <strong>support@gujjumarket.com</strong></p>
            <p>Gujju e-Market | All rights reserved</p>
        </div>
    </div>
</body>
</html>