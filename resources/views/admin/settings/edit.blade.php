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


                <!-- Manual Advertisement Banners (1 Top Banner + 2 Right Sidebar Ads) -->
                <div class="p-4 rounded-4 bg-body-tertiary border mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-rectangle-ad text-primary fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-0 text-body">Manual Advertisement Banners</h6>
                                <small class="text-muted">Directly control 1 Top Banner & 2 Right Sidebar Ads with images, links, and independent on/off switches.</small>
                            </div>
                        </div>
                    </div>

                    <!-- 1. Top Banner Ad -->
                    <div class="card border mb-4 shadow-none">
                        <div class="card-header bg-body d-flex justify-content-between align-items-center py-2 px-3">
                            <div class="fw-bold d-flex align-items-center gap-2 text-primary">
                                <i class="fas fa-window-maximize"></i> 1. Top Header / Homepage Banner Ad
                            </div>
                            <div class="form-check form-switch m-0">
                                <input class="form-check-input" type="checkbox" name="ad_top_banner_enabled" id="ad_top_banner_enabled" value="1" {{ old('ad_top_banner_enabled', $setting->ad_top_banner_enabled) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold small" for="ad_top_banner_enabled">Show Banner</label>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="ad_top_banner_file" class="form-label small fw-semibold">Upload Banner Image (Recommended: 728x90 or 970x90)</label>
                                    <input type="file" name="ad_top_banner_file" id="ad_top_banner_file" class="form-control rounded-3" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label for="ad_top_banner_image" class="form-label small fw-semibold">Or Image URL</label>
                                    <input type="url" name="ad_top_banner_image" id="ad_top_banner_image" class="form-control rounded-3" value="{{ old('ad_top_banner_image', str_starts_with($setting->ad_top_banner_image ?? '', 'http') ? $setting->ad_top_banner_image : '') }}" placeholder="https://example.com/banner.jpg">
                                </div>
                                <div class="col-12">
                                    <label for="ad_top_banner_link" class="form-label small fw-semibold">Target Redirect URL (Opens on Click)</label>
                                    <input type="url" name="ad_top_banner_link" id="ad_top_banner_link" class="form-control rounded-3" value="{{ old('ad_top_banner_link', $setting->ad_top_banner_link) }}" placeholder="https://advertiser-website.com">
                                </div>
                                @if($setting->ad_top_banner_image)
                                <div class="col-12">
                                    <div class="p-2 rounded bg-light border text-center">
                                        <small class="text-muted d-block mb-1 fw-bold">Current Top Banner Preview:</small>
                                        <img src="{{ $setting->ad_top_banner_image }}" alt="Top Banner" class="img-fluid rounded border" style="max-height: 80px; object-fit: contain;">
                                    </div>
                                </div>
                                @endif
                                <div class="col-12">
                                    <label for="ad_top_banner_code" class="form-label small fw-semibold text-muted">Optional Custom HTML / Script Code (Overrides image if provided)</label>
                                    <textarea name="ad_top_banner_code" id="ad_top_banner_code" rows="2" class="form-control font-monospace fs-8 rounded-3" placeholder="Paste custom ad HTML or iframe code...">{{ old('ad_top_banner_code', $setting->ad_top_banner_code) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Right Sidebar Ad 1 -->
                    <div class="card border mb-4 shadow-none">
                        <div class="card-header bg-body d-flex justify-content-between align-items-center py-2 px-3">
                            <div class="fw-bold d-flex align-items-center gap-2 text-primary">
                                <i class="fas fa-table-columns"></i> 2. Right Sidebar Ad #1 (Upper Sidebar)
                            </div>
                            <div class="form-check form-switch m-0">
                                <input class="form-check-input" type="checkbox" name="ad_sidebar_1_enabled" id="ad_sidebar_1_enabled" value="1" {{ old('ad_sidebar_1_enabled', $setting->ad_sidebar_1_enabled) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold small" for="ad_sidebar_1_enabled">Show Ad 1</label>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="ad_sidebar_1_file" class="form-label small fw-semibold">Upload Ad Image (Recommended: 300x250 or Square)</label>
                                    <input type="file" name="ad_sidebar_1_file" id="ad_sidebar_1_file" class="form-control rounded-3" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label for="ad_sidebar_1_image" class="form-label small fw-semibold">Or Image URL</label>
                                    <input type="url" name="ad_sidebar_1_image" id="ad_sidebar_1_image" class="form-control rounded-3" value="{{ old('ad_sidebar_1_image', str_starts_with($setting->ad_sidebar_1_image ?? '', 'http') ? $setting->ad_sidebar_1_image : '') }}" placeholder="https://example.com/sidebar-ad1.jpg">
                                </div>
                                <div class="col-12">
                                    <label for="ad_sidebar_1_link" class="form-label small fw-semibold">Target Redirect URL</label>
                                    <input type="url" name="ad_sidebar_1_link" id="ad_sidebar_1_link" class="form-control rounded-3" value="{{ old('ad_sidebar_1_link', $setting->ad_sidebar_1_link) }}" placeholder="https://sponsor-website.com">
                                </div>
                                @if($setting->ad_sidebar_1_image)
                                <div class="col-12">
                                    <div class="p-2 rounded bg-light border text-center">
                                        <small class="text-muted d-block mb-1 fw-bold">Current Sidebar Ad 1 Preview:</small>
                                        <img src="{{ $setting->ad_sidebar_1_image }}" alt="Sidebar Ad 1" class="img-fluid rounded border" style="max-height: 120px; object-fit: contain;">
                                    </div>
                                </div>
                                @endif
                                <div class="col-12">
                                    <label for="ad_sidebar_1_code" class="form-label small fw-semibold text-muted">Optional Custom HTML / Script Code</label>
                                    <textarea name="ad_sidebar_1_code" id="ad_sidebar_1_code" rows="2" class="form-control font-monospace fs-8 rounded-3" placeholder="Paste custom ad HTML or iframe code...">{{ old('ad_sidebar_1_code', $setting->ad_sidebar_1_code) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Right Sidebar Ad 2 -->
                    <div class="card border mb-0 shadow-none">
                        <div class="card-header bg-body d-flex justify-content-between align-items-center py-2 px-3">
                            <div class="fw-bold d-flex align-items-center gap-2 text-primary">
                                <i class="fas fa-table-columns"></i> 3. Right Sidebar Ad #2 (Lower Sidebar)
                            </div>
                            <div class="form-check form-switch m-0">
                                <input class="form-check-input" type="checkbox" name="ad_sidebar_2_enabled" id="ad_sidebar_2_enabled" value="1" {{ old('ad_sidebar_2_enabled', $setting->ad_sidebar_2_enabled) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold small" for="ad_sidebar_2_enabled">Show Ad 2</label>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="ad_sidebar_2_file" class="form-label small fw-semibold">Upload Ad Image (Recommended: 300x250 or 300x600)</label>
                                    <input type="file" name="ad_sidebar_2_file" id="ad_sidebar_2_file" class="form-control rounded-3" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label for="ad_sidebar_2_image" class="form-label small fw-semibold">Or Image URL</label>
                                    <input type="url" name="ad_sidebar_2_image" id="ad_sidebar_2_image" class="form-control rounded-3" value="{{ old('ad_sidebar_2_image', str_starts_with($setting->ad_sidebar_2_image ?? '', 'http') ? $setting->ad_sidebar_2_image : '') }}" placeholder="https://example.com/sidebar-ad2.jpg">
                                </div>
                                <div class="col-12">
                                    <label for="ad_sidebar_2_link" class="form-label small fw-semibold">Target Redirect URL</label>
                                    <input type="url" name="ad_sidebar_2_link" id="ad_sidebar_2_link" class="form-control rounded-3" value="{{ old('ad_sidebar_2_link', $setting->ad_sidebar_2_link) }}" placeholder="https://sponsor-website.com">
                                </div>
                                @if($setting->ad_sidebar_2_image)
                                <div class="col-12">
                                    <div class="p-2 rounded bg-light border text-center">
                                        <small class="text-muted d-block mb-1 fw-bold">Current Sidebar Ad 2 Preview:</small>
                                        <img src="{{ $setting->ad_sidebar_2_image }}" alt="Sidebar Ad 2" class="img-fluid rounded border" style="max-height: 120px; object-fit: contain;">
                                    </div>
                                </div>
                                @endif
                                <div class="col-12">
                                    <label for="ad_sidebar_2_code" class="form-label small fw-semibold text-muted">Optional Custom HTML / Script Code</label>
                                    <textarea name="ad_sidebar_2_code" id="ad_sidebar_2_code" rows="2" class="form-control font-monospace fs-8 rounded-3" placeholder="Paste custom ad HTML or iframe code...">{{ old('ad_sidebar_2_code', $setting->ad_sidebar_2_code) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Google AdSense & Advertisement Settings -->
                <div class="p-4 rounded-4 bg-body-tertiary border mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-ad text-warning fs-5"></i>
                            <div>
                                <h6 class="fw-bold mb-0 text-body">Google AdSense & Custom Ads</h6>
                                <small class="text-muted">Manage your website's monetisation scripts and ad placements</small>
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="adsense_enabled" id="adsense_enabled" value="1" {{ old('adsense_enabled', $setting->adsense_enabled ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small" for="adsense_enabled">Enable Ads</label>
                        </div>
                    </div>

                    <!-- Main AdSense Script (Head Tag) -->
                    <div class="mb-3">
                        <label for="adsense_script" class="form-label small fw-semibold">
                            Google AdSense Auto-Ads / Header Script (<code class="text-danger">&lt;head&gt;</code>)
                        </label>
                        <textarea name="adsense_script" id="adsense_script" rows="4" class="form-control font-monospace fs-8 rounded-3 @error('adsense_script') is-invalid @enderror" placeholder='e.g. <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-XXXXXXXXXXXXXXXX" crossorigin="anonymous"></script>'>{{ old('adsense_script', $setting->adsense_script) }}</textarea>
                        <div class="form-text small text-muted">Paste your official Google AdSense code snippet or auto-ads script here. It will automatically load in the website header.</div>
                        @error('adsense_script')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Header Banner Ad Unit -->
                    <div class="mb-3">
                        <label for="adsense_header_code" class="form-label small fw-semibold">Top Header Banner Ad Unit Code (Optional)</label>
                        <textarea name="adsense_header_code" id="adsense_header_code" rows="2" class="form-control font-monospace fs-8 rounded-3" placeholder="e.g. <ins class='adsbygoogle' ...></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>">{{ old('adsense_header_code', $setting->adsense_header_code) }}</textarea>
                    </div>

                    <!-- In-Article Ad Unit -->
                    <div class="mb-3">
                        <label for="adsense_article_code" class="form-label small fw-semibold">In-Article Middle Ad Unit Code (Optional)</label>
                        <textarea name="adsense_article_code" id="adsense_article_code" rows="2" class="form-control font-monospace fs-8 rounded-3" placeholder="e.g. In-article AdSense slot code...">{{ old('adsense_article_code', $setting->adsense_article_code) }}</textarea>
                    </div>

                    <!-- Sidebar Ad Unit -->
                    <div class="mb-0">
                        <label for="adsense_sidebar_code" class="form-label small fw-semibold">Sidebar Sticky Ad Unit Code (Optional)</label>
                        <textarea name="adsense_sidebar_code" id="adsense_sidebar_code" rows="2" class="form-control font-monospace fs-8 rounded-3" placeholder="e.g. Sidebar 300x250 or 300x600 AdSense slot code...">{{ old('adsense_sidebar_code', $setting->adsense_sidebar_code) }}</textarea>
                    </div>
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
