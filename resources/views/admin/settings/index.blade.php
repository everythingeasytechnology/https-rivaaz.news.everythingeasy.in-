@extends('layouts.admin')

@section('title', 'System Settings - Rivaaz Admin')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Title Area -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="m-0 fw-bold">SaaS Settings Console</h3>
            <p class="text-muted small m-0">Customize tenant logos, manage color palettes, configure APIs, and active payment gateways.</p>
        </div>
        <button class="btn btn-sm btn-primary d-flex align-items-center gap-2" onclick="alert('Configuration backups saved.');">
            <i class="fa-solid fa-floppy-disk"></i> Backup Settings
        </button>
    </div>

    <div class="row g-4">
        
        <!-- Left: Tenant Branding -->
        <div class="col-lg-6">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Tenant Branding</h5>
                
                <form onsubmit="event.preventDefault(); showNotification('Tenant branding rules applied.');">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Portal Logo Text</label>
                        <input type="text" class="form-control" value="RIVAAZ CHRONICLE">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Active Primary Theme Color</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color border-secondary-subtle" id="brandColorPicker" value="#FF4E4E" title="Choose brand color">
                            <input type="text" class="form-control" id="brandColorHex" value="#FF4E4E" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Google Typography font</label>
                        <select class="form-select">
                            <option value="outfit" selected>Outfit / Inter (Modern Newspaper)</option>
                            <option value="roboto">Roboto / Roboto Slab (Classic News)</option>
                            <option value="playfair">Playfair Display (Premium Editorial)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Layout Frame</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="stickyHeaderCheck" checked>
                            <label class="form-check-label small" for="stickyHeaderCheck">Sticky Megamenu Navigation bar</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="mobileBottomNavCheck" checked>
                            <label class="form-check-label small" for="mobileBottomNavCheck">Sticky Bottom navigation bar on mobile</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Apply Branding</button>

                </form>

            </div>

            <!-- Portal Contact Details -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 mt-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Portal Contact Details</h5>
                <form onsubmit="event.preventDefault(); showNotification('Portal contact details updated successfully.');">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Support Email Address</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-envelope text-secondary"></i></span>
                            <input type="email" class="form-control" value="contact@rivaaz.news" placeholder="contact@domain.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Contact Phone Number</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-phone text-secondary"></i></span>
                            <input type="text" class="form-control" value="+91 98765 43210" placeholder="+91 98765 43210" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Save Contact Info</button>
                </form>
            </div>

            <!-- Social Media Links -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 mt-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Social Media Links</h5>
                <form onsubmit="event.preventDefault(); showNotification('Social media channels configuration updated.');">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Facebook Profile URL</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="fa-brands fa-facebook-f text-primary"></i></span>
                            <input type="text" class="form-control" value="https://facebook.com/rivaaznews">
                            <div class="input-group-text bg-light">
                                <input class="form-check-input mt-0" type="checkbox" checked title="Show on portal">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Twitter / X URL</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="fa-brands fa-x-twitter"></i></span>
                            <input type="text" class="form-control" value="https://twitter.com/rivaaznews">
                            <div class="input-group-text bg-light">
                                <input class="form-check-input mt-0" type="checkbox" checked title="Show on portal">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Instagram URL</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="fa-brands fa-instagram text-danger"></i></span>
                            <input type="text" class="form-control" value="https://instagram.com/rivaaznews">
                            <div class="input-group-text bg-light">
                                <input class="form-check-input mt-0" type="checkbox" checked title="Show on portal">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">YouTube Channel URL</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="fa-brands fa-youtube text-danger"></i></span>
                            <input type="text" class="form-control" value="https://youtube.com/rivaaznews">
                            <div class="input-group-text bg-light">
                                <input class="form-check-input mt-0" type="checkbox" checked title="Show on portal">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Save Social Links</button>
                </form>
            </div>

        </div>

        <!-- Right: Integrations and Gateways -->
        <div class="col-lg-6">
            
            <!-- Integration keys -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Firebase & Push Credentials</h5>
                
                <form onsubmit="event.preventDefault(); showNotification('Firebase Push notification keys saved.');">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Firebase Web API Key</label>
                        <input type="password" class="form-control form-control-sm" value="AIzaSyA88921-X99283921AAJ">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Firebase Messaging Sender ID</label>
                        <input type="text" class="form-control form-control-sm" value="98721389271">
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Save Integrations</button>

                </form>
            </div>

            <!-- Payment Gateways toggles -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Subscription Payment Gateways</h5>
                <p class="text-muted small">Authorize checkout gates for premium tenant plans.</p>
                
                <div class="d-flex flex-column gap-3">
                    
                    <!-- Stripe -->
                    <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-body-tertiary">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-brands fa-cc-stripe fs-3 text-primary"></i>
                            <div>
                                <h6 class="fw-bold mb-0">Stripe Payment Gateway</h6>
                                <small class="text-muted">Cards, Apple Pay, Google Pay</small>
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked onchange="showNotification('Stripe Gateway visibility toggled')">
                        </div>
                    </div>

                    <!-- PayPal -->
                    <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-body-tertiary">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-brands fa-paypal fs-3 text-primary"></i>
                            <div>
                                <h6 class="fw-bold mb-0">PayPal Express Checkout</h6>
                                <small class="text-muted">PayPal Accounts and Bank credits</small>
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" onchange="showNotification('PayPal Gateway visibility toggled')">
                        </div>
                    </div>

                </div>

            </div>

            <!-- Legal & Static Pages Editor -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 mt-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Legal & Static Pages</h5>
                
                <form onsubmit="event.preventDefault(); showNotification('Static page content successfully saved.');">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select target Page</label>
                        <select class="form-select" id="pageSelect" onchange="loadStaticPageContent(this.value)">
                            <option value="privacy" selected>Privacy Policy</option>
                            <option value="terms">Terms & Conditions</option>
                            <option value="about">About Us</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Page Content Editor</label>
                        <textarea class="form-control" id="pageEditorContent" rows="6" style="font-size:0.85rem;"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Save Page Content</button>
                </form>
            </div>

            <!-- Multi-Language & Locales Manager -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 mt-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Multi-Language & Locales</h5>
                
                <form onsubmit="event.preventDefault(); showNotification('Active language configurations updated.');">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Primary Default Language</label>
                        <select class="form-select form-select-sm" id="defaultLocaleSelect">
                            <option value="hi" selected>Hindi (हिन्दी)</option>
                            <option value="en">English (US)</option>
                            <option value="es">Spanish (Español)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Active Locales</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="form-check small">
                                    <input class="form-check-input" type="checkbox" id="langHindi" checked>
                                    <label class="form-check-label" for="langHindi">Hindi (हिन्दी)</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check small">
                                    <input class="form-check-input" type="checkbox" id="langEnglish" checked>
                                    <label class="form-check-label" for="langEnglish">English</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check small">
                                    <input class="form-check-input" type="checkbox" id="langSpanish" onchange="showNotification('Spanish locale activated')">
                                    <label class="form-check-label" for="langSpanish">Spanish</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check small">
                                    <input class="form-check-input" type="checkbox" id="langArabic" onchange="showNotification('Arabic locale activated')">
                                    <label class="form-check-label" for="langArabic">Arabic (RTL)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-check form-switch small mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="autoTranslate" checked>
                        <label class="form-check-label" for="autoTranslate">Translate drafts automatically using AI (DeepL/OpenAI)</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Save Locales Settings</button>
                </form>
            </div>

        </div>

    </div>

</div>

<!-- Realtime color sync & static pages logic script -->
<script>
    document.getElementById('brandColorPicker').addEventListener('input', function(e) {
        document.getElementById('brandColorHex').value = e.target.value;
    });

    const pageContents = {
        'privacy': `Rivaaz Chronicle is committed to securing user privacy protection. We do not gather or trade user parameters without consent. Any cookie preferences configured will strictly follow GDPR audit benchmarks.`,
        'terms': `Rivaaz News Portal SaaS Terms & Conditions dictate terms of read-only access. By continuing portal navigation, you agree to comply with copyright protections and standard publication limitations.`,
        'about': `Rivaaz Chronicle is a premium, multi-tenant news portal SaaS designed to provide fast, unbiased, and high-fidelity journalism to global Hindi-speaking and regional audiences.`
    };

    function loadStaticPageContent(pageKey) {
        const text = pageContents[pageKey] || '';
        document.getElementById('pageEditorContent').value = text;
    }

    // Initialize content
    const pageSel = document.getElementById('pageSelect');
    if (pageSel) {
        loadStaticPageContent(pageSel.value);
    }
</script>
@endsection
