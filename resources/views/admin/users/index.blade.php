@extends('layouts.admin')

@section('page_title', 'Staff User Management')

@section('content')
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Registered Staff Accounts</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-user-plus me-2"></i>Register New Staff
        </a>
    </div>

    @if($errors->has('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle border-top">
            <thead class="table-light">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Role</th>
                    <th scope="col">Joined Date</th>
                    <th scope="col" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="fw-semibold">
                            <i class="fas fa-user-circle text-secondary me-2 fs-5"></i>{{ $user->name }}
                            @if(Auth::id() === $user->id)
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary border-opacity-25 ms-1">You</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'super_admin')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Super Admin</span>
                            @else
                                <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill">Editor / Writer</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(Auth::id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this staff user account?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-outline-danger rounded-circle disabled" title="Cannot delete yourself" disabled>
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
