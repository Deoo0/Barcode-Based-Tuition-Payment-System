<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Payment Receipt</h1>
        <p>Date: {{ now()->format('Y-m-d') }}</p>
    </div>

    <table class="table">
        <tr>
            <th>Student</th>
            <td>{{ $payment->student->name }}</td>
        </tr>
        <tr>
            <th>Amount</th>
            <td>₱{{ number_format($payment->amount, 2) }}</td>
        </tr>
        <tr>
            <th>Reference</th>
            <td>{{ $payment->reference_number }}</td>
        </tr>
    </table>
</body>
</html>