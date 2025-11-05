<div class="modal-header bg-warning text-dark">
    <h5 class="modal-title">Edit User - {{ $user->name }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

    <form action="/edit-user/{{ $user->id }}" method="POST" id="user-edit-form-{{ $user->id }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">User Type</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="usertype_id" value="2" {{ $user->usertype_id == 2 ? 'checked' : '' }}>
                <label class="form-check-label">Cashier</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="usertype_id" value="1" {{ $user->usertype_id == 1 ? 'checked' : '' }}>
                <label class="form-check-label">Admin</label>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="submit" form="user-edit-form-{{ $user->id }}" class="btn btn-warning">Update</button>
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
</div>
