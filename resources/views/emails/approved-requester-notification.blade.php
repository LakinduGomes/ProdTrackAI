<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
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
            background: linear-gradient(90deg, #1a73e8, #2565c6);
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
            color: #1a73e8;
            font-size: 20px;
            margin: 0 0 15px;
        }
        p {
            font-size: 15px;
            color: #555;
            margin: 16px 0;
        }
        .info-box {
            background-color: #f1f5fb;
            border-left: 4px solid #1a73e8;
            padding: 18px;
            margin: 25px 0;
            border-radius: 6px;
        }
        .button {
            display: inline-block;
            background-color: #1a73e8;
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
            background-color: #0f5bd7;
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
            color: #1a73e8;
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
        <h2>Technical Master Data Validation</h2>
    </div>

    <div class="content">
        <h1>Dear {{ $details['first_name'].' '.$details['last_name'] }},</h1>

        <p>You are receiving this email for <strong>Technical Master Data Validation <span style="color: green;">Approved</span></strong>. </p>

        <div class="info-box">
            <p><strong>Material Code:</strong> {{ $details['material_code'] }}</p>
            <p style="margin-bottom: 0;"><strong>Material Description:</strong> {{ $details['material_description'] }}</p>
        </div>

        @if(isset($details['materials']) && count($details['materials']) > 1)
        <div style="margin: 20px 0; padding: 15px; border: 1px solid #e0e0e0; border-radius: 5px; background-color: #f8fdf8;">
            <h3 style="color: #2e8b57; margin-bottom: 10px;">Revision Group #{{ $details['revision'] }} Approved</h3>
            <p>The following {{ $details['total_materials'] }} materials were approved together:</p>

            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="background-color: #f0f8f0;">
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd;">Material Code</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd;">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details['materials'] as $material)
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $material['code'] }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $material['description'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <a href="{{ $details['login_link'] }}" class="button">Login to Review</a>
        <div class="divider"></div>

        <p>Thank you for your time and attention to this matter.</p>

        <div class="signature">
            <p>Best Regards,<br>
            <strong>MDM Team</strong></p>
        </div>
    </div>

    <div class="footer">
        <p>If you have any questions, please contact our support team at <a href="mailto:masterdata@ceatsrilanka.com">masterdata@ceatsrilanka.com</a>.</p>
    </div>
</div>
</body>
</html>
