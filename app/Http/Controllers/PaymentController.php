<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request){
    // Create the payment record first
    $payment = Payment::create([
        'student_id' => $request->student_id,
        'cashier_id' => auth()->id(), // assumes user is logged in
        'amount' => $request->amount,
        'term' => $request->term,
        'payment_date' => $request->payment_date,
        'status' => $request->status,
        'payment_method' => $request->payment_method,
        'reference_number' => $request->reference,
    ]);

    // Fetch the student with program info
    $student = Student::with('program')->find($request->student_id);

    // Calculate total paid and tuition fee
    $totalPaid = Payment::where('student_id', $student->id)->sum('amount');
    $tuitionFee = $student->program->fee;

    // Determine status
    $status = 'Partial';

    if ($totalPaid >= $tuitionFee && $tuitionFee > 0) {
        $status = 'Completed';
    } elseif ($totalPaid == 0) {
        $status = 'Pending';
    }

    // Update the newly created payment's status
    $payment->status = $status;
    $payment->save();

    // Redirect or return response
    return redirect('payment')->with('success', 'Payment recorded successfully!');
}

}

