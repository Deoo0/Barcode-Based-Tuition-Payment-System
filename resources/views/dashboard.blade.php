@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('styles')
<style>
    .stat-card {
        transition: all 0.3s ease;
        border-left: 4px solid;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .stat-card.primary {
        border-left-color: #4e73df;
    }
    .stat-card.success {
        border-left-color: #1cc88a;
    }
    .stat-card.info {
        border-left-color: #36b9cc;
    }
    .stat-card.warning {
        border-left-color: #f6c23e;
    }
    .progress-sm {
        height: 0.5rem;
    }
    .activity-item {
        position: relative;
        padding-left: 1.5rem;
        border-left: 1px solid #e3e6f0;
    }
    .activity-item:before {
        content: "";
        position: absolute;
        top: 0;
        left: -6px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #e3e6f0;
    }
    .activity-item.active:before {
        background: #4e73df;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <!-- Total Students -->
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

        <!-- Total Revenue -->
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

        <!-- Pending Payments -->
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

        <!-- Completion Rate -->
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

    <!-- Content Row -->
    <div class="row">
        <!-- Revenue Chart -->
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
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Payment Methods</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="paymentMethodsChart"></canvas>
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

    <!-- Recent Activity -->
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
                                    <td>{{ $transaction->student->name }}</td>
                                    <td class="fw-semibold">₱{{ number_format($transaction->amount, 2) }}</td>
                                    <td>
                                    <span class="badge bg-{{ 
                                        $transaction->status == 'Paid' ? 'success' : 
                                        ($transaction->status == 'Pending' ? 'warning' : 
                                        'danger') 
                                    }}">
                                        {{ $transaction->status }}
                                    </span>
                                    <td>
                                    <td>{{ $transaction->cashier->name }}</td>
                                    <td>{{$transaction->payment_method}}</td>
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
                    <a href="#" class="btn btn-block btn-light mt-2">View All Transactions</a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
                </div>
                <div class="card-body">
                    <div class="activity-item active pb-3">
                        <div class="small text-gray-500">Today, 10:45 AM</div>
                        <p class="mb-0">New payment received from Juan Dela Cruz (₱12,500)</p>
                    </div>
                    <div class="activity-item pb-3">
                        <div class="small text-gray-500">Today, 9:30 AM</div>
                        <p class="mb-0">Maria Santos completed her payment</p>
                    </div>
                    <div class="activity-item pb-3">
                        <div class="small text-gray-500">Yesterday, 3:15 PM</div>
                        <p class="mb-0">New student registered: Pedro Reyes</p>
                    </div>
                    <div class="activity-item">
                        <div class="small text-gray-500">Yesterday, 10:00 AM</div>
                        <p class="mb-0">System maintenance completed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Revenue',
                data: [120000, 190000, 300000, 500000, 200000],
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctxMethods = document.getElementById('paymentMethodsChart').getContext('2d');
    const paymentChart = new Chart(ctxMethods, {
        type: 'doughnut',
        data: {
            labels: ['Cash', 'Credit Card', 'Bank Transfer'],
            datasets: [{
                data: [55, 30, 15],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf']
            }]
        },
        options: {
            cutout: '70%',
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection
