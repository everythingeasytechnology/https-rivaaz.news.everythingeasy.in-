@extends('layouts.admin')

@section('page_title', 'Edit Staff User')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="d-flex align-items-center gap-2 mb-4">
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h5 class="fw-bold mb-0">Modify Staff Account: {{ $user->name }}</h5>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label small fw-bold text-uppercase">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control rounded-3 @error('name') is-invalid @enderror" placeholder="e.g. Rajesh Sharma" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-uppercase">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control rounded-3 @error('email') is-invalid @enderror" placeholder="e.g. rajesh@news.com" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Box (Optional on edit) -->
                <div class="p-4 rounded-4 bg-body-tertiary border mb-4">
                    <h6 class="fw-bold mb-2">Change Password (Optional)</h6>
                    <p class="text-muted small mb-3">Leave blank if you do not wish to update this user's password.</p>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label small fw-semibold">New Password</label>
                        <input type="password" name="password" id="password" class="form-control rounded-3 @error('password') is-invalid @enderror" placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label for="password_confirmation" class="form-label small fw-semibold">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control rounded-3" placeholder="••••••••">
                    </div>
                </div>

                <!-- User Role (Restrict if editing self to avoid lockouts) -->
                <div class="mb-4">
                    <label for="role" class="form-label small fw-bold text-uppercase">User Role</label>
                    @if(Auth::id() === $user->id)
                        <select name="role" id="role" class="form-select rounded-3" disabled>
                            <option value="super_admin" selected>Super Admin</option>
                        </select>
                        <input type="hidden" name="role" value="super_admin">
                        <div class="form-text small text-muted">You cannot change your own role to prevent system administrative lockouts.</div>
                    @else
                        <select name="role" id="role" class="form-select rounded-3 @error('role') is-invalid @enderror" required>
                            <option value="editor" {{ old('role', $user->role) === 'editor' ? 'selected' : '' }}>Editor / Writer (Manage Categories & News Articles)</option>
                            <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>Super Admin (Full System Access & Settings Control)</option>
                        </select>
                    @endif
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Save Changes</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
