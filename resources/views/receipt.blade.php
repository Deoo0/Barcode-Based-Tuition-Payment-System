<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .content { margin: 20px; }
        .footer { margin-top: 30px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Payment Receipt</h2>
    </div>

    <div class="content">
        <p><strong>Student Name:</strong> {{ $student->name }}</p>
        <p><strong>Program:</strong> {{ $student->program->name }}</p>
        <p><strong>Amount Paid:</strong> ₱{{ number_format($payment->amount, 2) }}</p>
        <p><strong>Payment Method:</strong> {{ $payment->payment_method }}</p>
        <p><strong>Term:</strong> {{ $payment->term }}</p>
        <p><strong>Payment Date:</strong> {{ \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') }}</p>
        <p><strong>Status:</strong> {{ $payment->status }}</p>
        <p><strong>Reference Number:</strong> {{ $payment->reference_number }}</p>
    </div>

    <div class="footer">
        <p>This is a system-generated receipt. Please keep it for your records.</p>
    </div>
</body>
</html>
