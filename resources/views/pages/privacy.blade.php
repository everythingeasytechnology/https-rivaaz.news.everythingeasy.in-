@extends('layouts.app')

@section('title', 'Privacy Policy - Rivaaz Chronicle')

@section('content')
<div class="container-xl">
    
    <!-- Privacy Header -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <h1 class="headline-font fw-extrabold text-primary mb-2">Privacy Policy</h1>
        <p class="text-muted mb-0 small">Effective Date: July 11, 2026. Review details on user logs and cookie policies.</p>
    </div>

    <div class="row g-4">
        <!-- Policy content -->
        <div class="col-lg-8">
            <div class="bg-body-tertiary p-4 rounded-4 border border-secondary-subtle">
                <h4 class="headline-font fw-bold mb-3">1. Information We Collect</h4>
                <p>Rivaaz Chronicle collects basic user email data for bulletin subscriptions and custom app notifications. We log diagnostic details, analytics metadata, and local browser settings (like dark mode state and font-size preferences) to optimize visual presentation speeds.</p>

                <h4 class="headline-font fw-bold mt-4 mb-3">2. How We Use Information</h4>
                <p>Collected information is utilized to customize newsfeeds, enable seamless light/dark rendering cycles, verify active newsletter logins, and monitor server loading metrics to prevent DDOS scenarios.</p>

                <h4 class="headline-font fw-bold mt-4 mb-3">3. Cookies and Local Caches</h4>
                <p>We leverage local storage to save your visual custom parameters (font scale, dark mode). Third-party advertising partners may mount cookies to optimize promotional slots. You can clear settings via browser cache configurations at any time.</p>
                
                <h4 class="headline-font fw-bold mt-4 mb-3">4. Security Standards</h4>
                <p>All subscription data runs over secure SSL channels. Tenant configurations are isolated to prevent cross-db lookups or multi-client leakages.</p>
            </div>
        </div>

        <div class="col-lg-4">
            @include('components.widgets', ['type' => 'newsletter'])
        </div>
    </div>

</div>
@endsection
