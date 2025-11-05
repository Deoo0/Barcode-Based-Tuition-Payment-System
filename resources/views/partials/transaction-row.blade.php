<tr>
    <td class="ps-4 fw-semibold">{{ $transaction->reference_number }}</td>
    <td>
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="bi bi-person-fill"></i>
                </div>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="mb-0">{{ $transaction->student->first_name }}, {{ $transaction->student->last_name }}</h6>
                <small class="text-muted">{{ $transaction->student->student_number }}</small>
            </div>
        </div>
    </td>
    <td class="fw-semibold">₱{{ number_format($transaction->amount, 2) }}</td>
    <td>
        <span class="badge bg-light text-dark border">{{ $transaction->term }}</span>
    </td>
    <td>
        <span class="badge bg-{{ 
            $transaction->status == 'Paid' ? 'success' : 
            ($transaction->status == 'Pending' ? 'warning' : 
            'danger') 
        }}">
            {{ $transaction->status }}
        </span>
    </td>
    <td>{{ $transaction->cashier->name }}</td>
    <td>
        <span class="badge bg-light text-dark border text-capitalize">
            {{ $transaction->payment_method }}
        </span>
    </td>
    <td>{{ optional($transaction->created_at)->format('M d, Y') }}</td>
</tr>