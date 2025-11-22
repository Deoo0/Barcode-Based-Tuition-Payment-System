<div class="modal-header bg-warning text-dark">
    <h5 class="modal-title">Edit Student - {{ $student->first_name }} {{ $student->last_name }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="/edit-student/{{ $student->id }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="student_number" class="form-label">Student Number</label>
                <input type="number" name="student_number" id="student_number" class="form-control" value="{{$student->student_number}}" required>
            </div>

            <div class="col-md-6">
                <label for="name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter First Name" value="{{$student->first_name}}" required>
            </div>
            <div class="col-md-6">
                <label for="name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter Last Name" value="{{$student->last_name}}" required>
            </div>
            <div class="col-md-6">
                <label for="name" class="form-label">Middle Name</label>
                <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Enter Middle Name" value="{{$student->middle_name}}" required>
            </div>

            <div class="col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="number" name="phone" id="phone" class="form-control" value="{{$student->phone}}" required>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{$student->email}}" required>
            </div>

            <div class="col-md-12">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{$student->address}}" required>
            </div>

            <div class="col-md-12">
                <label class="form-label d-block">Program</label>
                @forelse ($programs as $index => $program)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="program_id" id="program_{{ $program->id }}" value="{{ $program->id }}" {{ $student->program_id == $program->id ? 'checked' : ($index === 0 ? 'checked' : '') }}>
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
</form>