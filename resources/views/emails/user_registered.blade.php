<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Registration - CEAT</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 40px 0;
        }
        .container {
            max-width: 640px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e1e1e1;
        }
        .header {
            background-color: #005baa;
            color: #ffffff;
            padding: 20px 30px;
            font-size: 22px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
            color: #333333;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin: 15px 0;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 20px 30px;
            text-align: center;
            font-size: 13px;
            color: #888;
        }
        .highlight {
            color: #005baa;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        Welcome to CEAT!
    </div>
    <div class="content">
        <p>Thank you for registering with the email: <span class="highlight">{{ $userEmail }}</span>.</p>

        <p>We have successfully received your information. Your registration form has been sent to <strong>CEAT</strong>. A member of our team will be in touch with you shortly.</p>

        <p>If you have any questions in the meantime, feel free to reply to this email or contact us directly.</p>

        <p style="margin-top: 30px;">Thank you for choosing <strong>CEAT</strong>.</p>

        <p style="margin-top: 40px;">Best regards,<br><strong>CEAT Team</strong></p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} CEAT. All rights reserved.
    </div>
</div>

</body>
</html>
