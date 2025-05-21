<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index(){
        $totalStudents = Student::count();
        $totalTransactions = Payment::count();
        $transactions = Payment::with(['student', 'cashier'])
            ->latest()
            ->paginate(10);

        // Count students who have completed payment
        $studentsWithCompletedPayment = Payment::where('status', 'completed')
            ->distinct('student_id')
            ->count('student_id');

        // Avoid division by zero
        $completionRate = $totalStudents > 0
            ? round(($studentsWithCompletedPayment / $totalStudents) * 100, 2)
            : 0;

         $paymentData = Payment::selectRaw('payment_method, COUNT(*) as total')
        ->groupBy('payment_method')
        ->pluck('total', 'payment_method');

        return view('dashboard', [
            'paymentData' => $paymentData,
            'transactions' => $transactions,
            'totalTransactions' => $totalTransactions,
            'totalStudents' => $totalStudents,
            'totalRevenue' => Payment::sum('amount'),
            'pendingPayments' => Payment::whereIn('status', ['pending', 'paid', 'partial'])->count(),
            'completionRate' => $completionRate,
        ]);
    }
}
