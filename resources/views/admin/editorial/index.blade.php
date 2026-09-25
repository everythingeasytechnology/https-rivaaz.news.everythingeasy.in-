@extends('layouts.admin')

@section('page_title', 'Editorial Board Management')

@section('content')
<div class="admin-card">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h5 class="fw-bold mb-1">Editorial Board Members</h5>
            <p class="text-muted small mb-0">Manage the leaders and editors displayed dynamically on the About Us page.</p>
        </div>
        <a href="{{ route('admin.editorial-board.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-user-plus me-2"></i>Add Member
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle border-top">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 80px;">Avatar</th>
                    <th scope="col">Name</th>
                    <th scope="col">Designation / Role</th>
                    <th scope="col" style="width: 100px;">Sort Order</th>
                    <th scope="col" style="width: 100px;">Status</th>
                    <th scope="col" style="width: 120px;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                    <tr>
                        <td>
                            <img src="{{ $member->avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80' }}" 
                                 alt="{{ $member->name }}" 
                                 class="rounded-circle border object-fit-cover shadow-sm" 
                                 style="width: 48px; height: 48px;">
                        </td>
                        <td>
                            <strong class="text-secondary-emphasis d-block">{{ $member->name }}</strong>
                            @if($member->bio)
                                <small class="text-muted">{{ Str::limit($member->bio, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1">
                                {{ $member->designation }}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted fw-semibold">{{ $member->sort_order }}</span>
                        </td>
                        <td>
                            @if($member->is_active)
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.editorial-board.edit', $member->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" title="Edit Member">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.editorial-board.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove {{ $member->name }} from the Editorial Board?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete Member">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-users fa-3x mb-3 text-secondary opacity-50"></i>
                            <p class="mb-2">No editorial board members found.</p>
                            <a href="{{ route('admin.editorial-board.create') }}" class="btn btn-sm btn-primary">Add Member</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($members->hasPages())
        <div class="mt-4">
            {{ $members->links() }}
        </div>
    @endif
</div>
@endsection
