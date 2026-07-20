@extends('layouts.app')

@section('title', 'संपर्क और विज्ञापन - द उत्तराखंड नाउ')

@section('content')
<div class="container-xl">
    
    <!-- Header banner -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <h1 class="headline-font fw-extrabold text-primary mb-2">संपर्क और पूछताछ</h1>
        <p class="text-muted mb-0 small">हमारे संपादकीय डेस्क, सहायता टीम से संपर्क करें या विज्ञापन अवसरों पर चर्चा करें।</p>
    </div>

    <div class="row g-4 mb-5">
        <!-- Contact Form (7 grid units) -->
        <div class="col-lg-8">
            <div class="card border-0 bg-body-tertiary p-4 rounded-4 shadow-sm border border-secondary-subtle">
                <h3 class="headline-font fw-bold mb-3">हमें संदेश भेजें</h3>
                <form onsubmit="event.preventDefault(); alert('आपका संदेश सफलतापूर्वक भेज दिया गया है! हमारी टीम जल्द ही आपसे संपर्क करेगी।'); this.reset();">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">पूरा नाम</label>
                            <input type="text" class="form-control rounded-3" placeholder="नाम लिखें" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">ईमेल पता</label>
                            <input type="email" class="form-control rounded-3" placeholder="email@example.com" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">विषय / विभाग</label>
                        <select class="form-select rounded-3">
                            <option>संपादकीय पूछताछ (Editorial Inquiries)</option>
                            <option>प्रायोजन और विज्ञापन (Sponsorships & Advertisements)</option>
                            <option>करियर के अवसर (Career Opportunities)</option>
                            <option>सामान्य सहायता (General Support)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">संदेश</label>
                        <textarea class="form-control rounded-3" rows="6" placeholder="अपना संदेश यहाँ लिखें..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill fw-bold px-4">संदेश भेजें</button>
                </form>
            </div>
        </div>

        <!-- Corporate Info Sidebar (4 grid units) -->
        <div class="col-lg-4">
            <!-- Details Box -->
            <div class="widget-box">
                <div class="widget-title">
                    <span>कार्यालय संपर्क विवरण</span>
                </div>
                <div class="d-flex flex-column gap-3 fs-7">
                    @if(!empty($siteSettings->contact_address))
                    <div>
                        <strong class="d-block text-primary"><i class="fas fa-map-marker-alt me-1"></i> मुख्य कार्यालय पता</strong>
                        <span class="text-muted">{!! nl2br(e($siteSettings->contact_address)) !!}</span>
                    </div>
                    @endif
                    
                    @if(!empty($siteSettings->contact_email))
                    <div>
                        <strong class="d-block text-primary"><i class="far fa-envelope me-1"></i> ईमेल संपर्क</strong>
                        <span class="text-muted">{{ $siteSettings->contact_email }}</span>
                    </div>
                    @endif
                    
                    @if(!empty($siteSettings->contact_phone))
                    <div>
                        <strong class="d-block text-primary"><i class="fas fa-phone-alt me-1"></i> हेल्पलाइन नंबर</strong>
                        <span class="text-muted">{{ $siteSettings->contact_phone }} (Mon-Fri)</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Simulated Maps Widget -->
            <div class="widget-box bg-secondary bg-opacity-10 border border-secondary border-opacity-25 rounded-4 p-4 text-center">
                <div class="fs-1 text-secondary mb-2"><i class="fas fa-map-marked-alt"></i></div>
                <h5 class="fw-bold">मानचित्र पर स्थिति</h5>
                <p class="text-muted small">मार्गदर्शन सहायता के लिए मानचित्र पर हमारी भू-स्थिति देखें।</p>
                <button class="btn btn-outline-secondary rounded-pill btn-sm px-3 fw-bold" onclick="alert('Google maps simulation clicked!')">मानचित्र खोलें</button>
            </div>
        </div>
    </div>

</div>
@endsection
