@extends('layouts.admin')

@section('page_title', 'Professional Newsroom - Edit Article')

@section('styles')
<!-- jQuery & Summernote WYSIWYG Editor CSS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<style>
    /* Professional News Editor Custom Styling */
    .note-editor.note-frame {
        border: 1px solid var(--bs-border-color) !important;
        border-radius: 12px !important;
        overflow: hidden;
        background-color: var(--bs-body-bg) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }
    .note-toolbar {
        background-color: var(--bs-tertiary-bg) !important;
        border-bottom: 1px solid var(--bs-border-color) !important;
        padding: 8px 12px !important;
    }
    .note-btn {
        background-color: var(--bs-body-bg) !important;
        border: 1px solid var(--bs-border-color) !important;
        border-radius: 6px !important;
        color: var(--bs-body-color) !important;
        padding: 4px 10px !important;
        font-size: 0.825rem !important;
    }
    .note-btn:hover {
        background-color: var(--bs-primary) !important;
        color: #fff !important;
        border-color: var(--bs-primary) !important;
    }
    .note-editable {
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
        font-size: 1.05rem !important;
        line-height: 1.7 !important;
        min-height: 420px !important;
        padding: 20px !important;
    }
    .news-preview-card {
        border-radius: 12px;
        border: 1px solid var(--bs-border-color);
        overflow: hidden;
        background: var(--bs-body-bg);
    }
    .editor-stat-badge {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 6px 12px;
        border-radius: 20px;
        background: var(--bs-tertiary-bg);
        border: 1px solid var(--bs-border-color);
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 mb-0 fw-bold text-gray-800"><i class="fas fa-edit text-primary me-2"></i>Edit News Story</h1>
            <p class="text-muted small mb-0">Update article content, metadata, and publishing settings.</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" id="newsArticleForm">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Main Writing Column (8 Grid Units) -->
        <div class="col-lg-8">
            
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                
                <!-- Headline Title -->
                <div class="mb-4">
                    <label for="title" class="form-label small fw-bold text-uppercase text-muted">Headline Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control form-control-lg fw-bold rounded-3 @error('title') is-invalid @enderror" placeholder="Enter bold headline title..." value="{{ old('title', $article->title) }}" required style="font-size: 1.4rem;">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- URL Slug -->
                <div class="mb-4">
                    <label for="slug" class="form-label small fw-bold text-uppercase text-muted">URL Slug</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 small text-muted">/news/</span>
                        <input type="text" name="slug" id="slug" class="form-control rounded-end-3 @error('slug') is-invalid @enderror" placeholder="news-url-slug" value="{{ old('slug', $article->slug) }}">
                    </div>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Subtitle / Hook -->
                <div class="mb-4">
                    <label for="subtitle" class="form-label small fw-bold text-uppercase text-muted">Subtitle / Headline Hook</label>
                    <input type="text" name="subtitle" id="subtitle" class="form-control rounded-3 @error('subtitle') is-invalid @enderror" placeholder="Secondary summary hook..." value="{{ old('subtitle', $article->subtitle) }}">
                    @error('subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Summary / Excerpt -->
                <div class="mb-4">
                    <label for="summary" class="form-label small fw-bold text-uppercase text-muted">Short Summary / Excerpt</label>
                    <textarea name="summary" id="summary" rows="3" class="form-control rounded-3 @error('summary') is-invalid @enderror" placeholder="Brief summary for previews...">{{ old('summary', $article->summary) }}</textarea>
                    @error('summary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category Selector -->
                <div class="mb-4">
                    <label for="category_id" class="form-label small fw-bold text-uppercase text-muted">Category Section <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="form-select rounded-3 @error('category_id') is-invalid @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $parent)
                            <option value="{{ $parent->id }}" {{ old('category_id', $article->category_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }} (Primary)
                            </option>
                            @foreach($parent->subcategories as $sub)
                                <option value="{{ $sub->id }}" {{ old('category_id', $article->category_id) == $sub->id ? 'selected' : '' }}>
                                    &nbsp;&nbsp;&nbsp;&nbsp;↳ {{ $sub->name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Featured Cover Media Box -->
                <div class="p-4 rounded-4 bg-body-tertiary border mb-4">
                    <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-photo-video me-2"></i>Cover Media (Image or Video)</h6>
                    
                    <div class="mb-3">
                        <label for="media_type" class="form-label small fw-bold text-uppercase text-muted">Cover Type</label>
                        <select name="media_type" id="media_type" class="form-select rounded-3 @error('media_type') is-invalid @enderror" required>
                            <option value="image_file" {{ old('media_type', $article->media_type ?? 'image_file') == 'image_file' ? 'selected' : '' }}>Upload Image File</option>
                            <option value="image_link" {{ old('media_type', $article->media_type) == 'image_link' ? 'selected' : '' }}>External Image URL Link</option>
                            <option value="video_file" {{ old('media_type', $article->media_type) == 'video_file' ? 'selected' : '' }}>Upload Video File</option>
                            <option value="video_link" {{ old('media_type', $article->media_type) == 'video_link' ? 'selected' : '' }}>External Video Link (YouTube/Vimeo)</option>
                        </select>
                    </div>

                    <!-- Image File Input -->
                    <div id="media-field-image-file" class="media-input-group mb-0">
                        <label for="image" class="form-label small fw-semibold">Select Featured Image</label>
                        <input type="file" name="image" id="image" class="form-control rounded-3 @error('image') is-invalid @enderror" accept="image/*">
                        @if($article->image_path && $article->media_type === 'image_file')
                            <div class="mt-2 text-muted small"><i class="fas fa-image me-1"></i>Current File: <code>{{ basename($article->image_path) }}</code></div>
                        @endif
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Video File Input -->
                    <div id="media-field-video-file" class="media-input-group mb-0" style="display: none;">
                        <label for="video" class="form-label small fw-semibold">Select Video File</label>
                        <input type="file" name="video" id="video" class="form-control rounded-3 @error('video') is-invalid @enderror" accept="video/*">
                        @if($article->video_path && $article->media_type === 'video_file')
                            <div class="mt-2 text-muted small"><i class="fas fa-video me-1"></i>Current Video: <code>{{ basename($article->video_path) }}</code></div>
                        @endif
                        @error('video')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- External Link Input -->
                    <div id="media-field-link" class="media-input-group mb-0" style="display: none;">
                        <label for="media_link" class="form-label small fw-semibold" id="media-link-label">External URL</label>
                        <input type="url" name="media_link" id="media_link" class="form-control rounded-3 @error('media_link') is-invalid @enderror" placeholder="https://..." value="{{ old('media_link', $article->media_link) }}">
                        @error('media_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Rich WYSIWYG Editor Body -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="content" class="form-label small fw-bold text-uppercase text-muted mb-0">Full News Article Content Body <span class="text-danger">*</span></label>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-9"><i class="fas fa-edit me-1"></i>Rich WYSIWYG Mode</span>
                    </div>
                    <textarea name="content" id="summernote" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $article->content) }}</textarea>
                    @error('content')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>

        </div>

        <!-- Sidebar Publishing & Live Metrics Column (4 Grid Units) -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 20px; z-index: 10;">
                <!-- Publishing Action Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h6 class="fw-bold mb-3 text-primary border-bottom pb-2"><i class="fas fa-paper-plane me-2"></i>Update Story</h6>
                    
                    <div class="mb-3">
                        <label for="published_at" class="form-label small fw-bold text-muted text-uppercase">Publish Date & Time</label>
                        <input type="datetime-local" name="published_at" id="published_at" class="form-control rounded-3" value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}">
                    </div>

                    <!-- Tags Input -->
                    <div class="mb-3">
                        <label for="tags" class="form-label small fw-bold text-muted text-uppercase">Tags (Comma Separated)</label>
                        <input type="text" name="tags" id="tags" class="form-control rounded-3" placeholder="e.g. Budget2026, Uttarakhand, Politics" value="{{ old('tags', $article->tags) }}">
                    </div>

                    <!-- Flags & Switches -->
                    <div class="p-3 bg-body-tertiary rounded-3 border mb-4">
                        <div class="form-check form-switch mb-2">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" class="form-check-input" {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}>
                            <label for="is_featured" class="form-check-label small fw-bold">Featured Story (Top Slot)</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_breaking" id="is_breaking" value="1" class="form-check-input" {{ old('is_breaking', $article->is_breaking) ? 'checked' : '' }}>
                            <label for="is_breaking" class="form-check-label small fw-bold text-danger">Breaking News Banner</label>
                        </div>
                    </div>

                    <!-- Editorial Live Metrics -->
                    <div class="mb-4">
                        <h6 class="small fw-bold text-uppercase text-muted mb-2"><i class="fas fa-chart-bar me-1"></i>Article Metrics</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <div class="editor-stat-badge"><i class="fas fa-font text-primary me-1"></i><span id="statWords">0</span> Words</div>
                            <div class="editor-stat-badge"><i class="fas fa-text-width text-info me-1"></i><span id="statChars">0</span> Chars</div>
                            <div class="editor-stat-badge"><i class="far fa-clock text-warning me-1"></i><span id="statReadTime">1</span> Min Read</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill py-2.5 fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i>Update Story Changes
                        </button>
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary rounded-pill py-2">
                            Cancel & Return
                        </a>
                    </div>
                </div>

                <!-- Live News Card Preview -->
                <div class="news-preview-card p-3 shadow-sm mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <small class="fw-bold text-uppercase text-muted fs-9"><i class="fas fa-eye me-1"></i>Website Preview Card</small>
                        <span class="badge bg-gold text-dark fs-9">Live Preview</span>
                    </div>
                    <div class="position-relative mb-2 rounded-3 overflow-hidden" style="aspect-ratio: 16/9; background: #222;">
                        <img id="previewImage" src="{{ $article->image_path ? asset($article->image_path) : 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=600&q=80' }}" class="w-100 h-100 object-fit-cover" alt="Preview">
                    </div>
                    <h6 class="fw-bold fs-7 mb-1 line-clamp-2" id="previewTitle">{{ $article->title }}</h6>
                    <small class="text-muted fs-9" id="previewMeta">Rivaaz News • {{ $article->published_at ? $article->published_at->format('M d, Y') : 'Published' }}</small>
                </div>
            </div>

        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize Summernote Professional WYSIWYG Editor
        $('#summernote').summernote({
            placeholder: 'Edit article content body...',
            tabsize: 2,
            height: 420,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph', 'height']],
                ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                ['view', ['fullscreen', 'codeview', 'undo', 'redo', 'help']]
            ],
            styleTags: [
                'p',
                { title: 'Blockquote', tag: 'blockquote', className: 'blockquote border-start border-4 border-primary ps-3 my-3', value: 'blockquote' },
                'h2', 'h3', 'h4'
            ],
            callbacks: {
                onChange: function(contents, $editable) {
                    updateArticleMetrics(contents);
                }
            }
        });

        // Media Type Toggle
        const mediaTypeSelect = document.getElementById('media_type');
        const imgFileGroup = document.getElementById('media-field-image-file');
        const vidFileGroup = document.getElementById('media-field-video-file');
        const linkGroup = document.getElementById('media-field-link');
        const linkLabel = document.getElementById('media-link-label');
        const linkHelp = document.getElementById('media-link-help');

        function toggleMediaFields() {
            const val = mediaTypeSelect.value;
            imgFileGroup.style.display = 'none';
            vidFileGroup.style.display = 'none';
            linkGroup.style.display = 'none';

            if (val === 'image_file') {
                imgFileGroup.style.display = 'block';
            } else if (val === 'image_link') {
                linkGroup.style.display = 'block';
                linkLabel.textContent = 'External Image URL';
                linkHelp.textContent = 'Enter direct image URL (e.g. https://domain.com/photo.jpg).';
            } else if (val === 'video_file') {
                vidFileGroup.style.display = 'block';
            } else if (val === 'video_link') {
                linkGroup.style.display = 'block';
                linkLabel.textContent = 'External Video URL';
                linkHelp.textContent = 'Enter YouTube or Vimeo URL link.';
            }
        }
        mediaTypeSelect.addEventListener('change', toggleMediaFields);
        toggleMediaFields();

        // Live Title & Metrics Calculator
        const titleInput = document.getElementById('title');
        const previewTitle = document.getElementById('previewTitle');

        titleInput.addEventListener('input', function() {
            previewTitle.textContent = this.value.trim() ? this.value : 'Article headline preview...';
        });

        function updateArticleMetrics(htmlContent) {
            const text = $('<div>').html(htmlContent).text().trim();
            const words = text ? text.split(/\s+/).filter(w => w.length > 0).length : 0;
            const chars = text.length;
            const readTime = Math.max(1, Math.ceil(words / 200));

            $('#statWords').text(words.toLocaleString());
            $('#statChars').text(chars.toLocaleString());
            $('#statReadTime').text(readTime);
        }

        // Initialize metrics on load
        updateArticleMetrics($('#summernote').summernote('code'));
    });
</script>
@endsection
