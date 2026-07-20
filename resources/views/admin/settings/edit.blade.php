@extends('layouts.admin')

@section('page_title', 'Global Website Settings')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <h5 class="fw-bold mb-4">Website Configuration</h5>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Site Name -->
                <div class="mb-3">
                    <label for="site_name" class="form-label small fw-bold text-uppercase">Site Name</label>
                    <input type="text" name="site_name" id="site_name" class="form-control rounded-3 @error('site_name') is-invalid @enderror" value="{{ old('site_name', $setting->site_name) }}" required>
                    @error('site_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Logo Upload -->
                <div class="mb-4">
                    <label for="logo" class="form-label small fw-bold text-uppercase">Upload New Logo</label>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        @if($setting->logo_path)
                            <img src="{{ $setting->logo_path }}" alt="Logo" class="border p-1 rounded bg-light" style="max-height: 50px; max-width: 150px; object-fit: contain;">
                        @else
                            <div class="border p-2 rounded bg-light text-muted small">No Logo Uploaded</div>
                        @endif
                        <input type="file" name="logo" id="logo" class="form-control rounded-3 @error('logo') is-invalid @enderror">
                    </div>
                    <div class="form-text small text-muted">Upload a transparent or styled image logo (JPEG, PNG, SVG). Recommended size is around 150x50 pixels.</div>
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Footer Text -->
                <div class="mb-3">
                    <label for="footer_text" class="form-label small fw-bold text-uppercase">Footer Description</label>
                    <textarea name="footer_text" id="footer_text" rows="3" class="form-control rounded-3 @error('footer_text') is-invalid @enderror">{{ old('footer_text', $setting->footer_text) }}</textarea>
                    @error('footer_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Contacts Section -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="contact_email" class="form-label small fw-bold text-uppercase">Contact Email</label>
                        <input type="email" name="contact_email" id="contact_email" class="form-control rounded-3 @error('contact_email') is-invalid @enderror" value="{{ old('contact_email', $setting->contact_email) }}">
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="contact_phone" class="form-label small fw-bold text-uppercase">Contact Phone</label>
                        <input type="text" name="contact_phone" id="contact_phone" class="form-control rounded-3 @error('contact_phone') is-invalid @enderror" value="{{ old('contact_phone', $setting->contact_phone) }}">
                        @error('contact_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Contact Address -->
                <div class="mb-4">
                    <label for="contact_address" class="form-label small fw-bold text-uppercase">Contact Address</label>
                    <textarea name="contact_address" id="contact_address" rows="3" class="form-control rounded-3 @error('contact_address') is-invalid @enderror" placeholder="Enter corporate offices addresses...">{{ old('contact_address', $setting->contact_address) }}</textarea>
                    @error('contact_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Social Links Box -->
                <div class="p-4 rounded-4 bg-body-tertiary border mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="fas fa-share-alt text-primary"></i>
                        <h6 class="fw-bold mb-0 text-primary">Social Media URLs</h6>
                    </div>

                    <div class="mb-3">
                        <label for="social_facebook" class="form-label small fw-semibold">Facebook Page URL</label>
                        <input type="url" name="social_facebook" id="social_facebook" class="form-control rounded-3" value="{{ old('social_facebook', $setting->social_facebook) }}">
                    </div>

                    <div class="mb-3">
                        <label for="social_twitter" class="form-label small fw-semibold">Twitter Profile URL</label>
                        <input type="url" name="social_twitter" id="social_twitter" class="form-control rounded-3" value="{{ old('social_twitter', $setting->social_twitter) }}">
                    </div>

                    <div class="mb-3">
                        <label for="social_instagram" class="form-label small fw-semibold">Instagram Profile URL</label>
                        <input type="url" name="social_instagram" id="social_instagram" class="form-control rounded-3" value="{{ old('social_instagram', $setting->social_instagram) }}">
                    </div>

                    <div class="mb-0">
                        <label for="social_linkedin" class="form-label small fw-semibold">LinkedIn Page URL</label>
                        <input type="url" name="social_linkedin" id="social_linkedin" class="form-control rounded-3" value="{{ old('social_linkedin', $setting->social_linkedin) }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">Save Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection
