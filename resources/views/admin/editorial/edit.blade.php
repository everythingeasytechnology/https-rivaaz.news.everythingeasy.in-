@extends('layouts.admin')

@section('page_title', 'Edit Editorial Board Member')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Edit Editorial Member</h5>
                <a href="{{ route('admin.editorial-board.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.editorial-board.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Member Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $member->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="designation" class="form-label fw-semibold">Designation / Role <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="designation" name="designation" value="{{ old('designation', $member->designation) }}" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="avatar_file" class="form-label fw-semibold">Upload New Avatar Image</label>
                        <input type="file" class="form-control" id="avatar_file" name="avatar_file" accept="image/*">
                        <div class="form-text">Leave blank to keep the current avatar.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="avatar_url" class="form-label fw-semibold">Or Avatar Image URL</label>
                        <input type="url" class="form-control" id="avatar_url" name="avatar_url" value="{{ old('avatar_url', str_starts_with($member->avatar ?? '', 'http') ? $member->avatar : '') }}" placeholder="https://example.com/avatar.jpg">
                        <div class="form-text">Direct image web address.</div>
                    </div>
                </div>

                @if($member->avatar)
                    <div class="mb-3 d-flex align-items-center gap-3 p-3 bg-light rounded-3 border">
                        <img src="{{ $member->avatar }}" alt="{{ $member->name }}" class="rounded-circle border object-fit-cover" style="width: 50px; height: 50px;">
                        <div>
                            <span class="d-block small fw-bold text-secondary">Current Avatar</span>
                            <small class="text-muted text-break">{{ $member->avatar }}</small>
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="bio" class="form-label fw-semibold">Brief Bio / Note (Optional)</label>
                    <textarea class="form-control" id="bio" name="bio" rows="3">{{ old('bio', $member->bio) }}</textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="sort_order" class="form-label fw-semibold">Display Order</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $member->sort_order) }}" min="0">
                        <div class="form-text">Lower numbers appear first on the About Us page.</div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center mt-3 mt-md-0">
                        <div class="form-check form-switch mt-3">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">Active & Visible on About Page</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.editorial-board.index') }}" class="btn btn-light rounded-pill px-4 border">Cancel</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Update Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
