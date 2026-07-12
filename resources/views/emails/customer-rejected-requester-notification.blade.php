<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Request Rejected</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #eef2f7;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }

        .email-container {
            background-color: #fff;
            max-width: 640px;
            margin: 30px auto;
            border-radius: 10px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(90deg, #c62828, #d32f2f);
            padding: 30px;
            text-align: center;
            color: #fff;
        }

        .header h2 {
            margin: 0;
            font-weight: 500;
            font-size: 24px;
        }

        .content {
            padding: 30px;
        }

        h1 {
            color: #c62828;
            font-size: 20px;
            margin: 0 0 15px;
        }

        p {
            font-size: 15px;
            color: #555;
            margin: 16px 0;
        }

        .info-box {
            background-color: #fbe9e7;
            border-left: 4px solid #c62828;
            padding: 18px;
            margin: 25px 0;
            border-radius: 6px;
        }

        .button {
            display: inline-block;
            background-color: #c62828;
            color: #fff !important;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 500;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #b71c1c;
        }

        .divider {
            border-top: 1px solid #e0e0e0;
            margin: 30px 0;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 22px;
            font-size: 13px;
            color: #777;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .footer a {
            color: #c62828;
            text-decoration: none;
        }

        .signature {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h2>Customer Request Rejected</h2>
        </div>

        <div class="content">
            <h1>Dear {{ $details['first_name'] }},</h1>

            <p>Your customer request with the code <strong>{{ $details['customer_code'] }}</strong> has been
                <strong>rejected</strong>.
            </p>

            <div class="info-box">
                <p><strong>Reason for rejection:</strong><br>{{ $details['reject_reason'] }}</p>
            </div>

            <p>You can review your request or take further actions using the link below:</p>

            <a href="{{ $details['login_link'] }}" class="button">Login to Review</a>

            <div class="divider"></div>

            <p>Thank you for your time and attention.</p>

            <div class="signature">
                <p>Best Regards,<br>
                    <strong>Customer Approval Team</strong>
                </p>
            </div>
        </div>

        <div class="footer">
            <p>If you have any questions, please contact our support team at
                <a href="mailto:masterdata@ceatsrilanka.com">masterdata@ceatsrilanka.com</a>.
            </p>
        </div>
    </div>
</body>

</html>