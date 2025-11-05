@php
    $fee = $student->program->fee ?? 0;
    $paid = $student->payments->sum('amount');
    $balance = max(0, $fee - $paid);
    $percent = $fee > 0 ? min(100, round(($paid / $fee) * 100, 1)) : 0;
@endphp

<div class="container-fluid py-2">
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="mb-1">{{ $student->last_name }}, {{ $student->first_name }} <small class="text-muted">• #{{ $student->student_number }}</small></h4>
                    <p class="mb-1"><strong>Program:</strong> {{ $student->program->name }}</p>
                    <p class="mb-0 small text-muted">Registered: {{ optional($student->created_at)->format('M d, Y') }}</p>
                </div>
            </div>

            <h5 class="mb-2">Payment History</h5>
            <div class="table-responsive">
                <table class="table table-striped table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Term</th>
                            <th>Reference</th>
                            <th class="text-end">Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($student->payments as $payment)
                        <tr>
                            <td>{{ $payment->term }}</td>
                            <td>{{ $payment->reference_number }}</td>
                            <td class="text-end">₱{{ number_format($payment->amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $payment->status == 'Paid' ? 'success' : ($payment->status == 'Partial' ? 'warning' : 'danger') }}">
                                    {{ $payment->status }}
                                </span>
                            </td>
                            <td>{{ $payment->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No payment records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Balance</h6>
                    <h3 class="mb-1 {{ $balance > 0 ? 'text-danger' : 'text-success' }}">₱{{ number_format($balance, 2) }}</h3>
                    <p class="mb-2 small text-muted">Total Tuition: ₱{{ number_format($fee, 2) }} • Paid: ₱{{ number_format($paid, 2) }}</p>

                    <div class="mb-3">
                        <div class="progress" style="height:8px">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">{{ $percent }}% paid</small>
                    </div>

                    <a href="/payment?student={{ $student->id }}" class="btn btn-primary btn-sm w-100">Make Payment</a>
                </div>
            </div>
        </div>
    </div>
</div>
