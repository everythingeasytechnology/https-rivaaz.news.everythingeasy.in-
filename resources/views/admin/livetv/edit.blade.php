@extends('layouts.admin')

@section('page_title', 'Live TV Configuration')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="d-flex align-items-center gap-2 mb-4">
                <h5 class="fw-bold mb-0">Live TV Stream Settings</h5>
            </div>

            <form action="{{ route('admin.livetv.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <p class="text-muted small mb-4">Configure the live broadcast link and fallback cover image displayed on the homepage.</p>

                <!-- Live TV Stream URL -->
                <div class="mb-4">
                    <label for="live_tv_url" class="form-label small fw-bold text-uppercase">Live TV Embed URL / Stream URL</label>
                    <input type="text" name="live_tv_url" id="live_tv_url" class="form-control rounded-3 @error('live_tv_url') is-invalid @enderror" placeholder="e.g. https://www.youtube.com/watch?v=..." value="{{ old('live_tv_url', $setting->live_tv_url) }}">
                    <div class="form-text small text-muted">
                        <strong>Supported formats:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            <li><strong>Standard watch links</strong>: <code>https://www.youtube.com/watch?v=VIDEO_ID</code></li>
                            <li><strong>Short sharing links</strong>: <code>https://youtu.be/VIDEO_ID</code></li>
                            <li><strong>Channel ID links</strong> (for permanent 24/7 streams): <code>https://www.youtube.com/channel/UC...</code></li>
                        </ul>
                    </div>
                    @error('live_tv_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Live TV Cover Image -->
                <div class="mb-4">
                    <label for="live_tv_cover" class="form-label small fw-bold text-uppercase">Live TV Cover Poster Image</label>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        @if($setting->live_tv_cover)
                            <img src="{{ $setting->live_tv_cover }}" alt="Live TV Cover" class="border p-1 rounded bg-dark" style="max-height: 120px; max-width: 240px; object-fit: cover;">
                        @else
                            <div class="border p-3 rounded bg-light text-muted small">No Cover Image Uploaded</div>
                        @endif
                        <input type="file" name="live_tv_cover" id="live_tv_cover" class="form-control rounded-3 @error('live_tv_cover') is-invalid @enderror">
                    </div>
                    <div class="form-text small text-muted">Upload a custom thumbnail cover image for the Live TV placeholder on the homepage grid. Recommended ratio: 16:9.</div>
                    @error('live_tv_cover')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">Update Live TV</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
