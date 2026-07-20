@extends('layouts.admin')

@section('page_title', 'Create Category')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="d-flex align-items-center gap-2 mb-4">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h5 class="fw-bold mb-0">New Category Details</h5>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                
                <!-- Category Name -->
                <div class="mb-3">
                    <label for="name" class="form-label small fw-bold text-uppercase">Category Name</label>
                    <input type="text" name="name" id="name" class="form-control rounded-3 @error('name') is-invalid @enderror" placeholder="e.g. Science" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mb-3">
                    <label for="slug" class="form-label small fw-bold text-uppercase">Custom URL Slug (Optional)</label>
                    <input type="text" name="slug" id="slug" class="form-control rounded-3 @error('slug') is-invalid @enderror" placeholder="e.g. science-and-tech" value="{{ old('slug') }}">
                    <div class="form-text small text-muted">Will be automatically generated from the name if left blank.</div>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Parent Category -->
                <div class="mb-4">
                    <label for="parent_id" class="form-label small fw-bold text-uppercase">Parent Category (Optional)</label>
                    <select name="parent_id" id="parent_id" class="form-select rounded-3 @error('parent_id') is-invalid @enderror">
                        <option value="">None (Make it a Parent Category)</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text small text-muted">Select a parent category if you want to create a subcategory (e.g. "Space" under "Science").</div>
                    @error('parent_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- SEO Configuration Box -->
                <div class="p-4 rounded-4 bg-body-tertiary border mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="fas fa-search text-primary"></i>
                        <h6 class="fw-bold mb-0 text-primary">SEO Settings (Meta Data)</h6>
                    </div>
                    <p class="text-muted small mb-3">Define how search engines index and display this category page.</p>

                    <!-- Meta Title -->
                    <div class="mb-3">
                        <label for="meta_title" class="form-label small fw-semibold">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control rounded-3" placeholder="e.g. Science & Space Technology News - Rivaaz" value="{{ old('meta_title') }}">
                    </div>

                    <!-- Meta Description -->
                    <div class="mb-3">
                        <label for="meta_description" class="form-label small fw-semibold">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="3" class="form-control rounded-3" placeholder="e.g. Read the latest coverage and scientific breakthroughs..."></textarea>
                    </div>

                    <!-- Meta Keywords -->
                    <div class="mb-0">
                        <label for="meta_keywords" class="form-label small fw-semibold">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control rounded-3" placeholder="e.g. science, space, physics, tech" value="{{ old('meta_keywords') }}">
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">Save Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Live SEO Snippet Preview Card -->
    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="admin-card">
            <h6 class="fw-bold mb-3"><i class="fab fa-google text-danger me-2"></i>Google Search Preview</h6>
            <div class="border rounded-3 p-3 bg-white text-dark shadow-sm" style="font-family: Arial, sans-serif;">
                <div class="text-truncate text-primary fs-6 mb-1" id="seo-preview-title" style="color: #1a0dab !important; font-weight: normal; cursor: pointer; text-decoration: none;">
                    New Category News - Rivaaz Chronicle
                </div>
                <div class="text-truncate text-success small mb-1" style="color: #006621 !important;">
                    http://127.0.0.1:8000/category/<span id="seo-preview-slug">new-category</span>
                </div>
                <div class="small text-muted" id="seo-preview-desc" style="color: #545454 !important; line-height: 1.4;">
                    Latest updates and news from the new category page.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const metaTitleInput = document.getElementById('meta_title');
        const metaDescInput = document.getElementById('meta_description');

        const previewTitle = document.getElementById('seo-preview-title');
        const previewSlug = document.getElementById('seo-preview-slug');
        const previewDesc = document.getElementById('seo-preview-desc');

        function generateSlug(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start
                .replace(/-+$/, '');            // Trim - from end
        }

        nameInput.addEventListener('input', function() {
            if (!slugInput.value || slugInput.dataset.edited === 'false') {
                const slug = generateSlug(nameInput.value);
                previewSlug.textContent = slug || 'new-category';
            }
            updatePreview();
        });

        slugInput.addEventListener('input', function() {
            slugInput.dataset.edited = 'true';
            previewSlug.textContent = generateSlug(slugInput.value) || 'new-category';
        });

        metaTitleInput.addEventListener('input', updatePreview);
        metaDescInput.addEventListener('input', updatePreview);

        slugInput.dataset.edited = 'false';

        function updatePreview() {
            previewTitle.textContent = metaTitleInput.value || (nameInput.value ? nameInput.value + ' News - Rivaaz Chronicle' : 'New Category News - Rivaaz Chronicle');
            previewDesc.textContent = metaDescInput.value || 'Latest updates and news from the new category page.';
        }
    });
</script>
@endsection
