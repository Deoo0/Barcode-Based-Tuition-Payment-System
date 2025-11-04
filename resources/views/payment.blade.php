@extends('layouts.app')

@section('title', 'Tuition Payment Portal')

@section('content')
<div class="payment-portal-container">
    <div class="container py-5">

        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-primary mb-3">Tuition Payment Portal</h1>
            <p class="lead text-muted">Scan student barcode or enter ID manually to process payments</p>
        </div>


        <div class="card shadow-lg border-0 rounded-3 mb-5">
            <div class="card-header bg-primary text-white rounded-top-3 py-3">
                <h5 class="mb-0"><i class="bi bi-upc-scan me-2"></i>Student Identification</h5>
            </div>
            <div class="card-body p-4">
                <form method="GET" action="/scan">
                    @csrf
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light"><i class="bi bi-person-badge"></i></span>
                        <input type="text" class="form-control form-control-lg"
                            name="barcode" id="barcode"
                            placeholder="Enter student ID "
                            autofocus>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-search me-2"></i>Search
                        </button>
                    </div>
                </form>
            </div>
        </div>


        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-4"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row g-4">

            <div class="col-lg-6">
                <div class="card shadow-sm h-100 border-0 rounded-3">
                    <div class="card-header bg-white border-bottom-0 rounded-top-3 py-3">
                        <h5 class="mb-0 fw-semibold text-primary">
                            <i class="bi bi-person-vcard me-2"></i>Student Details
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($student))

                        <div class="student-details-grid">
                            <div class="detail-item">
                                <span class="detail-label">Student ID</span>
                                <span class="detail-value">{{ $student->student_number }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Full Name</span>
                                <span class="detail-value">{{ $student->last_name }}, {{ $student->first_name }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Program</span>
                                <span class="detail-value">{{ $student->program->name }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Address</span>
                                <span class="detail-value">{{ $student->address }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Total Tuition</span>
                                <span class="detail-value">₱{{ number_format($student->program->fee, 2) }}</span>
                            </div>
                            @php
                            $balance = $student->program->fee - $student->payments->sum('amount');
                            @endphp
                            <div class="detail-item">
                                <span class="detail-label">Balance</span>
                                <span class="detail-value {{ $balance > 0 ? 'text-danger' : 'text-success' }}">
                                    ₱{{ number_format($balance, 2) }}
                                    @if($balance <= 0)
                                        <span class="badge bg-success ms-2">Paid in Full</span>
                                @endif
                                </span>
                            </div>
                        </div>


                        @if($balance > 0)
                        <div class="d-grid mt-4">
                            <button class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                <i class="bi bi-credit-card me-2"></i>Process Payment
                            </button>
                        </div>
                        @endif
                        @else
                        <div class="text-center py-4">
                            <i class="bi bi-person-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">No student selected. Please scan or enter a student ID.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="card shadow-sm h-100 border-0 rounded-3">
                    <div class="card-header bg-white border-bottom-0 rounded-top-3 py-3">
                        <h5 class="mb-0 fw-semibold text-primary">
                            <i class="bi bi-camera me-2"></i>Barcode Scanner
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="scanner-wrapper mb-3">
                            <div id="scanner-container" class="scanner-viewport rounded-3"></div>
                            <div class="scanner-overlay">
                                <div class="scanner-guide"></div>
                            </div>
                        </div>
                        <div class="scanner-controls mt-auto">
                            <button id="start-scanning" class="btn btn-primary btn-lg w-100 py-3">
                                <i class="bi bi-camera-fill me-2"></i>Activate Scanner
                            </button>
                            <button id="stop-scanning" class="btn btn-outline-danger btn-lg w-100 py-3 d-none">
                                <i class="bi bi-stop-circle me-2"></i>Stop Scanner
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if(isset($student) && ($student->program->fee - $student->payments->sum('amount') > 0))
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="paymentModalLabel">
                        <i class="bi bi-credit-card me-2"></i>Process Payment for {{ $student->name }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>



                <div class="modal-body">
                    <form id="paymentForm" method="POST" action="{{ route('process-payment')}}">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                        <input type="hidden" name="cashier_id" value="{{ auth()->user()->id }}">


                        <div class="mb-4">
                            <h6 class="text-primary mb-3"><i class="bi bi-cash-stack me-2"></i>Payment Information</h6>
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-4">
                                    <label for="amount" class="form-label">Amount*</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">₱</span>
                                        <input type="number" class="form-control"
                                            id="amount" name="amount"
                                            min="1"
                                            max="{{ $student->program->fee - $student->payments->sum('amount') }}"
                                            step="0.01" required>
                                    </div>
                                    <small class="text-muted">Max: ₱{{ number_format($student->program->fee - $student->payments->sum('amount'), 2) }}</small>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <label for="term" class="form-label">Term*</label>
                                    <select class="form-select" name="term" required>
                                        <option value="" selected disabled>Select Term</option>
                                        <option value="Paid">Initial</option>
                                        <option value="Prelim">Prelim</option>
                                        <option value="Midterms">Midterms</option>
                                        <option value="Prefinal">Prefinal</option>
                                        <option value="Finals">Finals</option>
                                    </select>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <label for="status" class="form-label">Status*</label>
                                    <select class="form-select" name="status" required>
                                        <option value="" selected disabled>Select Status</option>
                                        <option value="Paid">Initial</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Partial">Partial</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <label for="payment_method" class="form-label">Payment Method*</label>
                                    <select class="form-select" id="payment_method" name="payment_method" required>
                                        <option value="" selected disabled>Select Method</option>
                                        <option value="cash">Cash</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="online">Online Payment</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="mb-4">
                            <h6 class="text-primary mb-3"><i class="bi bi-receipt me-2"></i>Reference</h6>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="reference" class="form-label">Official Receipt No.</label>
                                    <input type="text" class="form-control" id="reference" name="reference" placeholder="Enter transaction OR No.">
                                    <small class="text-muted">Required for non-cash payments</small>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="payment_date" class="form-label">Payment Date</label>
                                    <input type="date" class="form-control" name="payment_date" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="balance-summary p-3 bg-light rounded-2 mb-4">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Current Balance:</span>
                                <strong>₱{{ number_format($student->program->fee - $student->payments->sum('amount'), 2) }}</strong>
                            </div>
                        </div>


                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Confirm and Submit Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
<script src="https://unpkg.com/html5-qrcode"></script>

@push('scripts')
<script type="module" src="{{Vite::asset('resource/js/payment.js')}}"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{Vite::asset('resource/css/payment.css')}}">
@endpush

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection