@extends('layouts.admin')

@section('title', 'Advertisements Manager - Rivaaz Admin')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Title Bar -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="m-0 fw-bold">Advertisement Placements</h3>
            <p class="text-muted small m-0">Configure scripts, custom HTML, and display blocks for Google Ad Manager / AdSense nodes.</p>
        </div>
        <button class="btn btn-sm btn-primary d-flex align-items-center gap-2" onclick="alert('Creating new custom ad slot...');">
            <i class="fa-solid fa-plus"></i> Create Ad Slot
        </button>
    </div>

    <!-- Ad networks performance metrics summary -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card border border-secondary-subtle p-3 rounded-3 shadow-sm">
                <span class="text-muted small text-uppercase fw-bold mb-1">Ad Impressions</span>
                <h4 class="fw-bold mb-1">420,500</h4>
                <small class="text-muted" style="font-size:0.75rem;"><strong class="text-success"><i class="fa-solid fa-arrow-trend-up"></i> +8%</strong> this week</small>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border border-secondary-subtle p-3 rounded-3 shadow-sm">
                <span class="text-muted small text-uppercase fw-bold mb-1">Average CTR</span>
                <h4 class="fw-bold mb-1">1.82%</h4>
                <small class="text-muted" style="font-size:0.75rem;"><strong class="text-danger"><i class="fa-solid fa-arrow-trend-down"></i> -0.2%</strong> vs yesterday</small>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border border-secondary-subtle p-3 rounded-3 shadow-sm">
                <span class="text-muted small text-uppercase fw-bold mb-1">Ad ECPM</span>
                <h4 class="fw-bold mb-1">$4.25</h4>
                <small class="text-muted" style="font-size:0.75rem;"><strong class="text-success"><i class="fa-solid fa-arrow-trend-up"></i> +1.4%</strong> vs global average</small>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border border-success-subtle bg-success bg-opacity-5 p-3 rounded-3 shadow-sm">
                <span class="text-success small text-uppercase fw-bold mb-1">Estimated Earnings</span>
                <h4 class="fw-bold text-success mb-1">$1,787.12</h4>
                <small class="text-success-emphasis" style="font-size:0.75rem;">Ad revenue node this month</small>
            </div>
        </div>
    </div>

    <!-- Active placements tabs and forms -->
    <div class="row g-4">
        
        <!-- Placements list -->
        <div class="col-lg-5">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 h-100">
                <h5 class="fw-bold mb-3">Active Placements</h5>
                
                <div class="d-flex flex-column gap-3">
                    
                    <!-- Header Ad -->
                    <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-body-tertiary">
                        <div>
                            <h6 class="fw-bold mb-0">Header Leaderboard Ad</h6>
                            <small class="text-muted">Standard 728x90 Billboard • Desktop</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked onchange="showNotification('Header Ad visibility toggled')">
                        </div>
                    </div>

                    <!-- Sidebar Ad -->
                    <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-body-tertiary">
                        <div>
                            <h6 class="fw-bold mb-0">Sidebar Sticky Square Ad</h6>
                            <small class="text-muted">Standard 300x250 Box • Desktop/Tablet</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked onchange="showNotification('Sidebar Ad visibility toggled')">
                        </div>
                    </div>

                    <!-- In-Article Ad -->
                    <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-body-tertiary">
                        <div>
                            <h6 class="fw-bold mb-0">In-Article Paragraph Ad</h6>
                            <small class="text-muted">Native responsive slot • All devices</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked onchange="showNotification('In-Article Ad visibility toggled')">
                        </div>
                    </div>

                    <!-- Pop-up Overlay Ad -->
                    <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-body-tertiary">
                        <div>
                            <h6 class="fw-bold mb-0">Pop-up Interstitial Ad</h6>
                            <small class="text-muted">Exit-intent floating module • Mobile/Desktop</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" onchange="showNotification('Pop-up Ad visibility toggled')">
                        </div>
                    </div>

                    <!-- Video Instream Ad -->
                    <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-body-tertiary">
                        <div>
                            <h6 class="fw-bold mb-0">Video Pre-Roll Ad</h6>
                            <small class="text-muted">Vast/Vpaid tag • Video player channel</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked onchange="showNotification('Pre-Roll Ad visibility toggled')">
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Ad Slot detail Editor -->
        <div class="col-lg-7">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 h-100">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Modify Placement Parameters</h5>
                
                <form onsubmit="event.preventDefault(); showNotification('Ad Slot configurations updated.');">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select target Slot</label>
                        <select class="form-select" id="adSlotSelector">
                            <option value="header" selected>Header Leaderboard Ad (728x90)</option>
                            <option value="sidebar">Sidebar Sticky Square Ad (300x250)</option>
                            <option value="in_article">In-Article Paragraph Ad</option>
                            <option value="popup">Pop-up Interstitial Ad</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Ad Provider Network</label>
                        <select class="form-select" id="adProvider" onchange="switchAdProvider(this.value)">
                            <option value="adsense">Google Adsense Autotag</option>
                            <option value="admanager" selected>Google Ad Manager Slot</option>
                            <option value="custom">Custom HTML / Script code</option>
                        </select>
                    </div>

                    <!-- Ad script content area -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Ad Slot Tag / Code</label>
                        <textarea class="form-control font-monospace bg-body-tertiary" rows="6" id="adSlotCode" style="font-size:0.75rem; line-height:1.4;"><!-- Google Ad Manager Slot Initialization -->
<div id='div-gpt-ad-16788329-0' style='min-width: 728px; min-height: 90px;'>
  <script>
    googletag.cmd.push(function() { 
      googletag.display('div-gpt-ad-16788329-0'); 
    });
  </script>
</div></textarea>
                    </div>

                    <!-- Devices view switches -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold d-block">Target Platforms</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="desktop" checked>
                            <label class="form-check-label small" for="inlineCheckbox1">Desktop</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="tablet" checked>
                            <label class="form-check-label small" for="inlineCheckbox2">Tablet</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="mobile">
                            <label class="form-check-label small" for="inlineCheckbox3">Mobile</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Save Changes</button>

                </form>

            </div>
        </div>

    </div>

</div>

<!-- Scripts for dynamic ad views switching -->
<script>
    function switchAdProvider(provider) {
        const textarea = document.getElementById('adSlotCode');
        if (provider === 'adsense') {
            textarea.value = `<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-123456789" crossorigin="anonymous"><\/script>\n<!-- Header auto-responsive layout -->\n<ins class="adsbygoogle"\n     style="display:block"\n     data-ad-client="ca-pub-123456789"\n     data-ad-slot="987654321"\n     data-ad-format="auto"\n     data-full-width-responsive="true"></ins>\n<script>\n     (adsbygoogle = window.adsbygoogle || []).push({});\n<\/script>`;
        } else if (provider === 'admanager') {
            textarea.value = `<!-- Google Ad Manager Slot Initialization -->\n<div id='div-gpt-ad-16788329-0' style='min-width: 728px; min-height: 90px;'>\n  <script>\n    googletag.cmd.push(function() { \n      googletag.display('div-gpt-ad-16788329-0'); \n    });\n  <\/script>\n</div>`;
        } else if (provider === 'custom') {
            textarea.value = `<!-- Custom Banner script -->\n<a href="https://rivaaz.news.everythingeasy.in" target="_blank">\n  <img src="/assets/images/banner.jpg" class="img-fluid" alt="Promo banner">\n</a>`;
        }
    }
</script>
@endsection
