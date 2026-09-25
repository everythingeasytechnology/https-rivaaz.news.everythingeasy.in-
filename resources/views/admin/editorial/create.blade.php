@extends('layouts.admin')

@section('page_title', 'Add Editorial Board Member')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Add New Editorial Member</h5>
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

            <form action="{{ route('admin.editorial-board.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Member Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Rajesh Sharma" required>
                </div>

                <div class="mb-3">
                    <label for="designation" class="form-label fw-semibold">Designation / Role <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="designation" name="designation" value="{{ old('designation') }}" placeholder="e.g. Chief Political Director, Technology Desk Lead, Editor-in-Chief" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="avatar_file" class="form-label fw-semibold">Upload Avatar Image</label>
                        <input type="file" class="form-control" id="avatar_file" name="avatar_file" accept="image/*">
                        <div class="form-text">JPG, PNG, WEBP up to 2MB. Square ratio recommended.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="avatar_url" class="form-label fw-semibold">Or Avatar Image URL</label>
                        <input type="url" class="form-control" id="avatar_url" name="avatar_url" value="{{ old('avatar_url') }}" placeholder="https://example.com/avatar.jpg">
                        <div class="form-text">Used if no image file is uploaded.</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label fw-semibold">Brief Bio / Note (Optional)</label>
                    <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Brief background or achievements of the editorial member...">{{ old('bio') }}</textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="sort_order" class="form-label fw-semibold">Display Order</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                        <div class="form-text">Lower numbers appear first on the About Us page (0, 1, 2...).</div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center mt-3 mt-md-0">
                        <div class="form-check form-switch mt-3">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">Active & Visible on About Page</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.editorial-board.index') }}" class="btn btn-light rounded-pill px-4 border">Cancel</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Save Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
