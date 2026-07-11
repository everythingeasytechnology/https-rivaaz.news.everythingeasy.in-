@extends('layouts.app')

@section('title', 'About Us - Rivaaz Chronicle')

@section('content')
<div class="container-xl">
    
    <!-- About Header -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <h1 class="headline-font fw-extrabold text-primary mb-2">Our Mission & Legacy</h1>
        <p class="text-muted mb-0 small">Rivaaz Chronicle is a premium, multi-tenant digital publication SaaS delivering verified bulletins and analysis.</p>
    </div>

    <div class="row g-4 mb-5">
        <!-- Main details -->
        <div class="col-lg-8">
            <h3 class="headline-font fw-bold mb-3">Independent. Verified. Real-time.</h3>
            <p>Rivaaz Chronicle is built on the core foundation of public accountability, ethical reporting, and tech-driven delivery systems. Designed to operate across multiple tenants, our SaaS framework supports dozens of localized bureaus to customize their content, layout hierarchies, and brand guidelines seamlessly.</p>
            
            <p>Our editorial desks cover a wide breadth of domains, bringing readers high-fidelity galleries, interactive live updates, and detailed video reviews on topics spanning national politics, global economics, technology evolutions, wellness, and local sports.</p>
            
            <blockquote>
                "In an era filled with micro-headlines and rapid content, we strive to build a readable modern newspaper that respects readers' focus, guarantees clean accessibility, and loads instantly."
            </blockquote>

            <h4 class="headline-font fw-bold mt-4 mb-3 border-bottom pb-2">Editorial Guidelines</h4>
            <ul>
                <li class="mb-2"><strong>Accuracy First:</strong> Every bulletin is double-checked by our editorial board before printing.</li>
                <li class="mb-2"><strong>Clear Correction Logs:</strong> Any corrections in reports are logged transparently on our archives.</li>
                <li class="mb-2"><strong>Accessibility Ready:</strong> Layout styles are optimized for readers with diverse text sizing and color contrast requirements.</li>
                <li class="mb-2"><strong>Zero Intrusive Ads:</strong> Ad space allocations follow Google Discover guidelines, preventing screen jumps.</li>
            </ul>
        </div>

        <!-- Sidebar (Board & Directors) -->
        <div class="col-lg-4">
            <div class="widget-box">
                <div class="widget-title">
                    <span>Editorial Board</span>
                </div>
                <div class="d-flex flex-column gap-3 fs-7">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=80&q=80" class="rounded-circle border" style="width:45px;height:45px;object-fit:cover;" alt="Avatar">
                        <div>
                            <strong class="d-block text-secondary-emphasis">Rajesh Sharma</strong>
                            <small class="text-muted">Chief Political Director</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=80&q=80" class="rounded-circle border" style="width:45px;height:45px;object-fit:cover;" alt="Avatar">
                        <div>
                            <strong class="d-block text-secondary-emphasis">Ananya Sen</strong>
                            <small class="text-muted">Technology Desk Lead</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=80&q=80" class="rounded-circle border" style="width:45px;height:45px;object-fit:cover;" alt="Avatar">
                        <div>
                            <strong class="d-block text-secondary-emphasis">Vikram Malhotra</strong>
                            <small class="text-muted">Editor-in-Chief (Finance)</small>
                        </div>
                    </div>
                </div>
            </div>

            @include('components.widgets', ['type' => 'newsletter'])
        </div>
    </div>

</div>
@endsection
