@extends('layouts.app')

@section('title', 'Admin Dashboard')


@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalStudents}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₱{{ number_format($totalRevenue, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-peso-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Pending Payments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingPayments }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Payment Completion</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $completionRate }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $completionRate }}%" 
                                            aria-valuenow="{{ $completionRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percent fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">View Options:</div>
                            <a class="dropdown-item" href="#">This Year</a>
                            <a class="dropdown-item" href="#">This Month</a>
                            <a class="dropdown-item" href="#">This Week</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="revenueChart" 
    data-labels='@json($revenueLabels ?? [])'
    data-values='@json($revenueValues ?? [])'
></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Payment Methods</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="paymentMethodsChart" data-payment='@json(isset($paymentData) ? $paymentData : ['Cash' => 55, 'Credit Card' => 30, 'Bank Transfer' => 15])'></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Cash
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Credit Card
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Bank Transfer
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Transactions</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Ref#</th>
                                    <th>Student</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Cashier</th>
                                    <th>Method</th>
                                    <th class="pe-4">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->reference_number }}</td>
                                    <td>
                                        @php
                                            $student = $transaction->student;
                                            $studentName = '—';
                                            if ($student) {
                                                if (!empty($student->last_name) || !empty($student->first_name)) {
                                                    $studentName = trim(($student->last_name ?? '') . ', ' . ($student->first_name ?? ''));
                                                } else {
                                                    $studentName = $student->name ?? '—';
                                                }
                                            }
                                        @endphp
                                        {{ $studentName }}
                                    </td>
                                    <td class="fw-semibold">₱{{ number_format($transaction->amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->status == 'Paid' ? 'success' : ($transaction->status == 'Pending' ? 'warning' : 'danger') }}">
                                            {{ $transaction->status }}
                                        </span>
                                    </td>
                                    <td>{{ optional($transaction->cashier)->name ?? '—' }}</td>
                                    <td>{{ $transaction->payment_method }}</td>
                                    <td>{{ optional($transaction->created_at)->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <p class="text-muted">There are no transactions to display at this time</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <a href="/transactions" class="btn btn-block btn-light mt-2">View All Transactions</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <!-- Load Chart.js first, then initialize charts using Blade data -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            try {
                // Revenue chart (fallback static data if controller doesn't provide dynamic data)
                var revenueEl = document.getElementById('revenueChart');
                if (revenueEl && typeof Chart !== 'undefined') {
                    var ctxRevenue = revenueEl.getContext('2d');
                    // Parse revenue data from canvas attributes
                    var labels = JSON.parse(revenueEl.getAttribute('data-labels') || '[]');
                    var values = JSON.parse(revenueEl.getAttribute('data-values') || '[]');
                    
                    new Chart(ctxRevenue, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Monthly Revenue',
                                data: values,
                                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                                borderColor: 'rgba(78, 115, 223, 1)',
                                borderWidth: 2,
                                tension: 0.3 // Slightly smooth the line
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return '₱' + value.toLocaleString();
                                        }
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return 'Revenue: ₱' + context.raw.toLocaleString();
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Payment methods chart - use $paymentData if provided by controller, otherwise fallback
                var methodsEl = document.getElementById('paymentMethodsChart');
                if (methodsEl && typeof Chart !== 'undefined') {
                    var raw = methodsEl.getAttribute('data-payment') || '{}';
                    var paymentData = {};
                    try { paymentData = JSON.parse(raw); } catch (e) { console.warn('Invalid payment data JSON:', e); }
                    var paymentLabels = Object.keys(paymentData);
                    var paymentValues = Object.values(paymentData);

                    var ctxMethods = methodsEl.getContext('2d');
                    new Chart(ctxMethods, {
                        type: 'doughnut',
                        data: {
                            labels: paymentLabels,
                            datasets: [{
                                data: paymentValues,
                                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#d4a017', '#c0392b']
                            }]
                        },
                        options: {
                            cutout: '70%',
                            responsive: true,
                            plugins: { legend: { position: 'bottom' } }
                        }
                    });
                }
            } catch (err) {
                console.error('Error initializing dashboard charts:', err);
            }
        });
    </script>
@endpush

@push('css')
<link rel="stylesheet" href="{{Vite::asset('resources/css/dashboard.css')}}">
@endpush
