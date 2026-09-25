@extends('layouts.admin')

@section('page_title', 'Register Staff User')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="d-flex align-items-center gap-2 mb-4">
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h5 class="fw-bold mb-0">Register New Admin/Editor</h5>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label small fw-bold text-uppercase">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control rounded-3 @error('name') is-invalid @enderror" placeholder="e.g. Rajesh Sharma" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-uppercase">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control rounded-3 @error('email') is-invalid @enderror" placeholder="e.g. rajesh@news.com" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label small fw-bold text-uppercase">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control rounded-start-3 @error('password') is-invalid @enderror" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary rounded-end-3 toggle-password-btn" type="button" data-target="password" title="Show / Hide Password">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label small fw-bold text-uppercase">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control rounded-start-3" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary rounded-end-3 toggle-password-btn" type="button" data-target="password_confirmation" title="Show / Hide Password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- User Role -->
                <div class="mb-4">
                    <label for="role" class="form-label small fw-bold text-uppercase">User Role</label>
                    <select name="role" id="role" class="form-select rounded-3 @error('role') is-invalid @enderror" required>
                        <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor / Writer (Manage Categories & News Articles)</option>
                        <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin (Full System Access & Settings Control)</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Register User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-password-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var targetId = this.getAttribute('data-target');
            var input = document.getElementById(targetId);
            var icon = this.querySelector('i');
            
            if (input) {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        });
    });
});
</script>
@endsection
