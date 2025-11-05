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
        $revenueData = Payment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(amount) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Format revenue data for the chart
        $revenueLabels = [];
        $revenueValues = [];

        // Create array of last 6 months (including current)
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push([
                'month' => $date->month,
                'year' => $date->year,
                'label' => $date->format('M Y'),
            ]);
        }

        // Map revenue data to months, using 0 for months with no data
        foreach ($months as $month) {
            $revenue = $revenueData->first(function ($item) use ($month) {
                return $item->month == $month['month'] && $item->year == $month['year'];
            });
            
            $revenueLabels[] = $month['label'];
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
