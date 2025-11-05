<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Payment;
use App\Models\Student;

use Illuminate\Http\Request;
use App\Mail\PaymentReceiptMail;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function payment(Request $request)
{
    // Validate request data here if not done elsewhere

    // Create the payment record first
    $payment = Payment::create([
        'student_id' => $request->student_id,
        'cashier_id' => auth()->id(),
        'amount' => $request->amount,
        'term' => $request->term,
        'payment_date' => $request->payment_date,
        'status' => $request->status,
        'payment_method' => $request->payment_method,
        'reference_number' => $request->reference,
    ]);

    // Fetch the student with program info and payments relation
    $student = Student::with(['program', 'payments'])->findOrFail($request->student_id);

    // Calculate total paid and tuition fee
    $totalPaid = $student->payments->sum('amount');
    $tuitionFee = $student->program->fee;

    // Determine status
    if ($totalPaid >= $tuitionFee && $tuitionFee > 0) {
        $status = 'Completed';
        $payment->status = $status;
    } elseif ($totalPaid == 0) {
        $status = 'Pending';
        $payment->status = $status;
    } else {
        $status = $payment->status;
    }

    // Update the newly created payment's status
    $payment->save();

    // Calculate remaining balance
    $balance = max(0, $tuitionFee - $totalPaid);

    // Prepare rendered row HTML for immediate UI insertion (if table exists on the page)
    $payment->load(['student', 'cashier']);
    $rowHtml = view('partials.transaction-row', ['transaction' => $payment])->render();

    // Return JSON response with useful data for AJAX updates
    return response()->json([
        'success' => true,
        'message' => 'Payment recorded successfully!',
        'payment' => $payment,
        'total_paid' => $totalPaid,
        'tuition_fee' => $tuitionFee,
        'balance' => $balance,
        'status' => $status,
        'student_id' => $student->id,
        'row' => $rowHtml,
    ]);
}
}

