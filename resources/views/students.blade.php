@extends('layouts.app')

@section('title','Students')

@section('content')
<div class="container" style="max-width: 15000px">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">🎓 Student Management</h2>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            <i class="bi bi-plus-lg me-1"></i>Add Student
        </button>
    </div>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('students.search') }}" method="GET">
                <div class="input-group">
                    <input type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search by name, student number, phone or program..."
                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Search
                    </button>
                    @if(request('search'))
                    <a href="{{ route('students.search') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x"></i> Clear
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="addStudentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="/addStudent" method="POST">
                @csrf
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="student_number" class="form-label">Student Number</label>
                                <input type="number" name="student_number" id="student_number" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter First Name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter Last Name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Middle Name</label>
                                <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Enter Middle Name" required>
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="number" name="phone" id="phone" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label d-block">Program</label>
                                @forelse ($programs as $index => $program)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="program_id" id="program_{{ $program->id }}" value="{{ $program->id }}" {{ $index === 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="program_{{ $program->id }}">{{ $program->name }}</label>
                                </div>
                                @empty
                                <p>No programs available.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Student No.</th>
                            <th>Last name</th>
                            <th>First name</th>
                            <th>Middle name</th>
                            <th>Program</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Registered At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->student_number }}</td>
                            <td>{{ $student->last_name }}</td>
                            <td>{{ $student->first_name }}</td>
                            <td>{{ $student->middle_name }}</td>
                            <td>{{ $student->program->name }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->address }}</td>
                            <td>{{ optional($student->created_at)->format('M d, Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">

                                    <button type="button" class="btn btn-sm btn-info view-student-btn" data-student-id="{{ $student->id }}">
                                        <i class="bi bi-search"></i> View
                                    </button>

                                    @if (Auth::check() && Auth::user()->usertype->id == 1)

                                    <button class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    <form action="/delete/student/{{ $student->id }}" method="POST" onsubmit="return confirm('Are you sure?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash3"></i> Delete
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No students found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Single dynamic modal for student details (content loaded via AJAX) -->
<div class="modal fade" id="studentDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-body d-flex justify-content-center py-5">
                
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="/js/students.js"></script>
@endpush