@extends('layouts.app')

@section('title', 'Contact & Advertise - Rivaaz Chronicle')

@section('content')
<div class="container-xl">
    
    <!-- Header banner -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <h1 class="headline-font fw-extrabold text-primary mb-2">Contact & Inquiries</h1>
        <p class="text-muted mb-0 small">Get in touch with our editorial desks, support team, or discuss enterprise advertisement spaces.</p>
    </div>

    <div class="row g-4 mb-5">
        <!-- Contact Form (7 grid units) -->
        <div class="col-lg-8">
            <div class="card border-0 bg-body-tertiary p-4 rounded-4 shadow-sm border border-secondary-subtle">
                <h3 class="headline-font fw-bold mb-3">Send us a message</h3>
                <form onsubmit="event.preventDefault(); alert('Message sent successfully! Our team will get back to you.'); this.reset();">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Full Name</label>
                            <input type="text" class="form-control rounded-3" placeholder="Jane Doe" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Email address</label>
                            <input type="email" class="form-control rounded-3" placeholder="jane@example.com" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Subject / Department</label>
                        <select class="form-select rounded-3">
                            <option>Editorial Inquiries</option>
                            <option>Sponsorships & Advertisements</option>
                            <option>Corporate SaaS Inquiries</option>
                            <option>Career Opportunities</option>
                            <option>General Support</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Message</label>
                        <textarea class="form-control rounded-3" rows="6" placeholder="Write your message here..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill fw-bold px-4">Submit Message</button>
                </form>
            </div>
        </div>

        <!-- Corporate Info Sidebar (4 grid units) -->
        <div class="col-lg-4">
            <!-- Details Box -->
            <div class="widget-box">
                <div class="widget-title">
                    <span>Corporate Offices</span>
                </div>
                <div class="d-flex flex-column gap-3 fs-7">
                    <div>
                        <strong class="d-block text-primary"><i class="fas fa-map-marker-alt me-1"></i> New Delhi HQ</strong>
                        <span class="text-muted">12-A, Parliament Street, Connaught Place, New Delhi - 110001</span>
                    </div>
                    <div>
                        <strong class="d-block text-primary"><i class="fas fa-map-marker-alt me-1"></i> Mumbai Bureau</strong>
                        <span class="text-muted">Express Towers, Nariman Point, Mumbai - 400021</span>
                    </div>
                    <div>
                        <strong class="d-block text-primary"><i class="far fa-envelope me-1"></i> Email</strong>
                        <span class="text-muted">editor@rivaazchronicle.com<br>advertise@rivaazchronicle.com</span>
                    </div>
                    <div>
                        <strong class="d-block text-primary"><i class="fas fa-phone-alt me-1"></i> Hotline</strong>
                        <span class="text-muted">+91 (11) 2345-6789 (Mon-Fri)</span>
                    </div>
                </div>
            </div>

            <!-- Simulated Maps Widget -->
            <div class="widget-box bg-secondary bg-opacity-10 border border-secondary border-opacity-25 rounded-4 p-4 text-center">
                <div class="fs-1 text-secondary mb-2"><i class="fas fa-map-marked-alt"></i></div>
                <h5 class="fw-bold">Interactive Location Map</h5>
                <p class="text-muted small">Our geolocation scripts are ready. Check coordinates for navigation support.</p>
                <button class="btn btn-outline-secondary rounded-pill btn-sm px-3 fw-bold" onclick="alert('Google maps simulation clicked!')">Open in Maps</button>
            </div>
        </div>
    </div>

</div>
@endsection
