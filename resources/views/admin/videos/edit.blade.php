@extends('layouts.admin')

@section('page_title', 'Edit Video News')

@section('content')
<div class="row">
    <div class="col-lg-9">
        <div class="admin-card">
            <div class="d-flex align-items-center gap-2 mb-4">
                <a href="{{ route('admin.videos.index') }}" class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h5 class="fw-bold mb-0">Edit Video News</h5>
            </div>

            <form action="{{ route('admin.videos.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Article Title -->
                <div class="mb-3">
                    <label for="title" class="form-label small fw-bold text-uppercase">Video Title</label>
                    <input type="text" name="title" id="title" class="form-control rounded-3 @error('title') is-invalid @enderror" placeholder="e.g. Dynamic T-20 Cricket Final" value="{{ old('title', $article->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- URL Slug -->
                <div class="mb-3">
                    <label for="slug" class="form-label small fw-bold text-uppercase">URL Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control rounded-3 @error('slug') is-invalid @enderror" placeholder="e.g. cricket-match-final" value="{{ old('slug', $article->slug) }}">
                    <div class="form-text small text-muted">Will be automatically regenerated from the title if updated and left blank.</div>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Subtitle / Headline -->
                <div class="mb-3">
                    <label for="subtitle" class="form-label small fw-bold text-uppercase">Subtitle / hook</label>
                    <input type="text" name="subtitle" id="subtitle" class="form-control rounded-3 @error('subtitle') is-invalid @enderror" placeholder="e.g. Brief details about the video clip" value="{{ old('subtitle', $article->subtitle) }}">
                    @error('subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Summary -->
                <div class="mb-3">
                    <label for="summary" class="form-label small fw-bold text-uppercase">Short Summary / Description</label>
                    <textarea name="summary" id="summary" rows="3" class="form-control rounded-3 @error('summary') is-invalid @enderror" placeholder="Provide a summary for previews and social sharing...">{{ old('summary', $article->summary) }}</textarea>
                    @error('summary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category Selector -->
                <div class="mb-4">
                    <label for="category_id" class="form-label small fw-bold text-uppercase">Category / Subsection</label>
                    <select name="category_id" id="category_id" class="form-select rounded-3 @error('category_id') is-invalid @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $parent)
                            <option value="{{ $parent->id }}" {{ old('category_id', $article->category_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
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

                <!-- Featured Cover Image Upload (Thumbnail) -->
                <div class="mb-4 p-4 rounded-4 bg-body-tertiary border">
                    <h6 class="fw-bold mb-3 text-primary"><i class="far fa-image me-2"></i>Thumbnail Settings</h6>
                    @if($article->image_path)
                        <div class="mb-3">
                            <label class="form-label small d-block">Current Thumbnail Poster</label>
                            <img src="{{ $article->image_path }}" class="img-fluid rounded-3 border" style="max-height: 120px;" alt="Poster">
                        </div>
                    @endif
                    <div class="mb-0">
                        <label for="image" class="form-label small fw-bold text-uppercase">Upload New Video Thumbnail / Cover Image</label>
                        <input type="file" name="image" id="image" class="form-control rounded-3 @error('image') is-invalid @enderror">
                        <div class="form-text small text-muted">Upload high-resolution landscape images (JPEG, PNG). Max size: 2MB. Leave blank to keep current thumbnail.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Video Sources Settings -->
                <div class="p-4 rounded-4 bg-body-tertiary border mb-4">
                    <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-video me-2"></i>Video Source Settings</h6>
                    
                    <div class="mb-3">
                        <label for="media_type" class="form-label small fw-bold text-uppercase">Video Source Type</label>
                        <select name="media_type" id="media_type" class="form-select rounded-3 @error('media_type') is-invalid @enderror" required>
                            <option value="video_file" {{ old('media_type', $article->media_type) == 'video_file' ? 'selected' : '' }}>Upload Video File (.mp4 / .mov)</option>
                            <option value="video_link" {{ old('media_type', $article->media_type) == 'video_link' ? 'selected' : '' }}>External Video Link (YouTube / Vimeo)</option>
                        </select>
                        @error('media_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Video File Input -->
                    <div id="media-field-video-file" class="media-input-group mb-0">
                        @if($article->media_type === 'video_file' && $article->video_path)
                            <div class="mb-3">
                                <label class="form-label small d-block">Current Video File Path</label>
                                <code class="bg-dark text-white p-2 rounded d-block text-break">{{ $article->video_path }}</code>
                            </div>
                        @endif
                        <label for="video" class="form-label small fw-semibold">Select Video File</label>
                        <input type="file" name="video" id="video" class="form-control rounded-3 @error('video') is-invalid @enderror">
                        <div class="form-text small text-muted">Upload a new video file to replace the current one. Max size: 20MB.</div>
                        @error('video')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- External Link Input -->
                    <div id="media-field-link" class="media-input-group mb-0" style="display: none;">
                        <label for="media_link" class="form-label small fw-semibold">External Video URL</label>
                        <input type="url" name="media_link" id="media_link" class="form-control rounded-3 @error('media_link') is-invalid @enderror" placeholder="https://www.youtube.com/watch?v=..." value="{{ old('media_link', $article->media_link) }}">
                        <div class="form-text small text-muted">Enter the full web URL (e.g. YouTube watch URL).</div>
                        @error('media_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const mediaTypeSelect = document.getElementById('media_type');
                        const vidFileGroup = document.getElementById('media-field-video-file');
                        const linkGroup = document.getElementById('media-field-link');

                        function toggleMediaFields() {
                            const val = mediaTypeSelect.value;
                            
                            vidFileGroup.style.display = 'none';
                            linkGroup.style.display = 'none';

                            if (val === 'video_file') {
                                vidFileGroup.style.display = 'block';
                            } else if (val === 'video_link') {
                                linkGroup.style.display = 'block';
                            }
                        }

                        mediaTypeSelect.addEventListener('change', toggleMediaFields);
                        toggleMediaFields();
                    });
                </script>

                <!-- Content Body -->
                <div class="mb-4">
                    <label for="content" class="form-label small fw-bold text-uppercase">Video Description / Body</label>
                    <textarea name="content" id="content" rows="6" class="form-control rounded-3 @error('content') is-invalid @enderror" placeholder="Provide full details or comments on this video..." required>{{ old('content', $article->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sidebar Settings Box -->
                <div class="p-4 rounded-4 bg-body-tertiary border mb-4">
                    <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-sliders-h me-2"></i>Publishing Controls</h6>
                    <div class="row g-3">
                        <!-- Tags -->
                        <div class="col-12">
                            <label for="tags" class="form-label small fw-bold">Tags (Comma Separated)</label>
                            <input type="text" name="tags" id="tags" class="form-control rounded-3" placeholder="e.g. खेल, क्रिकेट, मैच" value="{{ old('tags', $article->tags) }}">
                        </div>

                        <!-- Published At -->
                        <div class="col-md-6">
                            <label for="published_at" class="form-label small fw-bold">Published Date/Time</label>
                            <input type="datetime-local" name="published_at" id="published_at" class="form-control rounded-3" value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}">
                            <div class="form-text small text-muted">Leave empty to keep original published time.</div>
                        </div>

                        <!-- Flags -->
                        <div class="col-md-6 d-flex align-items-center gap-4 mt-lg-4">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" class="form-check-input" {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}>
                                <label for="is_featured" class="form-check-label small fw-bold">Featured Story</label>
                            </div>
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_breaking" id="is_breaking" value="1" class="form-check-input" {{ old('is_breaking', $article->is_breaking) ? 'checked' : '' }}>
                                <label for="is_breaking" class="form-check-label small fw-bold text-danger">Breaking News</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">Update Video News</button>
                    <a href="{{ route('admin.videos.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
