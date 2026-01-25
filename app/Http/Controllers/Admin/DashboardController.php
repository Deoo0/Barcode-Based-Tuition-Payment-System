<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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


        // Get revenue data for the last 6 months
        $revenueData = Payment::selectRaw("
        DATE_TRUNC('month', created_at) as month,
        SUM(amount) as total
        ")
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->where('status', 'Paid')
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();


        $revenueLabels = [];
        $revenueValues = [];

        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i)->startOfMonth();
            $months->push($date);
        }

        foreach ($months as $month) {
            $revenue = $revenueData->first(function ($item) use ($month) {
                return Carbon::parse($item->month)->equalTo($month);
            });

            $revenueLabels[] = $month->format('M Y');
            $revenueValues[] = $revenue ? round($revenue->total, 2) : 0;
        }



        // Map revenue data to months, using 0 for months with no data
        foreach ($months as $month) {
            $revenue = $revenueData->first(function ($item) use ($month) {
                return $item->month == $month['month'] && $item->year == $month['year'];
            });
            
            $revenueLabels[] = $month->format('M Y');
            $revenueValues[] = $revenue ? round($revenue->total, 2) : 0;
        }


        return view('dashboard', [
            'paymentData' => $paymentData,
            'transactions' => $transactions,
            'totalTransactions' => $totalTransactions,
            'totalStudents' => $totalStudents,
            'totalRevenue' => Payment::sum('amount'),
            'pendingPayments' => Payment::whereIn('status', ['pending', 'paid', 'partial'])->count(),
            'completionRate' => $completionRate,
            'revenueLabels' => $revenueLabels,
            'revenueValues' => $revenueValues,
        ]);
    }
}
