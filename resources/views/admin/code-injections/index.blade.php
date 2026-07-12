@extends('layouts.admin')

@section('title', 'Code Injections - Rivaaz Admin')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Title Section -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="m-0 fw-bold">Custom Code Injections</h3>
            <p class="text-muted small m-0">Inject custom tracking scripts, Google Analytics tags, and custom verification metadata into site layers.</p>
        </div>
        <button class="btn btn-sm btn-primary" onclick="alert('Code injection script parameters saved.');">
            <i class="fa-solid fa-floppy-disk"></i> Save Scripts
        </button>
    </div>

    <div class="row g-4">
        
        <!-- Script textareas (Left - 7 Grid Units) -->
        <div class="col-lg-7">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                
                <form onsubmit="event.preventDefault(); showNotification('Custom script injections applied successfully.');">
                    
                    <!-- Head section script -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold d-flex justify-content-between">
                            <span>Header Scripts (Injected inside &lt;head&gt;)</span>
                            <span class="text-muted" style="font-size:0.7rem;">HTML, Meta, or Script tags</span>
                        </label>
                        <textarea class="form-control font-monospace bg-body-tertiary" rows="5" style="font-size:0.75rem; line-height:1.4;"><!-- Google Analytics Global site tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-RIVAAZ2026"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-RIVAAZ2026');
</script></textarea>
                    </div>

                    <!-- Body Start script -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold d-flex justify-content-between">
                            <span>Body Start Scripts (Injected right after &lt;body&gt; opens)</span>
                            <span class="text-muted" style="font-size:0.7rem;">Noscript tag or fallback modules</span>
                        </label>
                        <textarea class="form-control font-monospace bg-body-tertiary" rows="3" style="font-size:0.75rem; line-height:1.4;"><!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-RIVAAZ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript></textarea>
                    </div>

                    <!-- Footer script -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold d-flex justify-content-between">
                            <span>Footer Scripts (Injected right before &lt;/body&gt; closes)</span>
                            <span class="text-muted" style="font-size:0.7rem;">Live chats, cookie popups, stats counters</span>
                        </label>
                        <textarea class="form-control font-monospace bg-body-tertiary" rows="3" style="font-size:0.75rem; line-height:1.4;"><!-- Custom Portal Live Chat Widget -->
<script>
  console.log("Rivaaz news portal layout script load complete.");
</script></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Apply Injections</button>

                </form>

            </div>
        </div>

        <!-- Google Search Console verification helper (Right - 5 Grid Units) -->
        <div class="col-lg-5">
            
            <!-- Google Search Console Helper -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Google Search Console Verification</h5>
                <p class="text-muted small">Paste your Search Console verification code key here to generate meta tags.</p>
                
                <form onsubmit="generateGoogleMetaTag(event)">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Verification Key</label>
                        <input type="text" class="form-control form-control-sm" id="googleKeyInput" value="google-site-verification=a1b2c3d4e5f6g7h8i9j0" placeholder="e.g. google123456789" required>
                    </div>
                    <button type="submit" class="btn btn-dark btn-sm rounded-pill px-4 fw-bold mb-3">Build Meta Tag</button>
                </form>

                <!-- Generated preview -->
                <div class="bg-body-tertiary p-3 rounded-3 border border-secondary-subtle">
                    <span class="d-block small fw-bold mb-2">Resulting Code Preview</span>
                    <pre class="font-monospace text-success small mb-0" id="googleMetaPreview" style="white-space: pre-wrap; font-size:0.7rem;">&lt;meta name="google-site-verification" content="google-site-verification=a1b2c3d4e5f6g7h8i9j0" /&gt;</pre>
                </div>
            </div>

            <!-- Header Info Notice -->
            <div class="card border border-info-subtle bg-info bg-opacity-5 p-4 rounded-3">
                <h6 class="fw-bold text-info-emphasis mb-2"><i class="fa-solid fa-circle-info me-2"></i>Code Injection Rules</h6>
                <ul class="small text-muted mb-0 ps-3">
                    <li>Inject scripts responsibly. Unresolved tags can cause layout blocks.</li>
                    <li>Always close all `<script>` and `<div>` tags properly.</li>
                    <li>Google Analytics tags should always be injected inside the header section.</li>
                </ul>
            </div>

        </div>

    </div>

</div>

<!-- Google Meta tag generation scripts -->
<script>
    function generateGoogleMetaTag(e) {
        e.preventDefault();
        const key = document.getElementById('googleKeyInput').value.trim();
        const preview = document.getElementById('googleMetaPreview');
        if (!key) return;
        
        preview.textContent = `<meta name="google-site-verification" content="${key}" />`;
        showNotification('Google site verification tag updated.');
    }
</script>
@endsection
