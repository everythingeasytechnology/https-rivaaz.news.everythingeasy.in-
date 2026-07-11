@extends('layouts.app')

@section('title', 'Terms of Service - Rivaaz Chronicle')

@section('content')
<div class="container-xl">
    
    <!-- Terms Header -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <h1 class="headline-font fw-extrabold text-primary mb-2">Terms of Service</h1>
        <p class="text-muted mb-0 small">Effective Date: July 11, 2026. General terms governing SaaS access rules.</p>
    </div>

    <div class="row g-4">
        <!-- Terms content -->
        <div class="col-lg-8">
            <div class="bg-body-tertiary p-4 rounded-4 border border-secondary-subtle">
                <h4 class="headline-font fw-bold mb-3">1. Terms Acceptance</h4>
                <p>By browsing Rivaaz Chronicle, subscribing to newsletters, or accessing our media galleries, you confirm agreement to follow our fair-use copyright clauses, local state laws, and access limitations.</p>

                <h4 class="headline-font fw-bold mt-4 mb-3">2. Content Copyright</h4>
                <p>All articles, photos, video skins, branding, and layouts are the intellectual property of Rivaaz Chronicle. Scraping content, duplicating mock logs, or cloning multi-tenant components without prior corporate agreements is strictly prohibited.</p>

                <h4 class="headline-font fw-bold mt-4 mb-3">3. SaaS Accounts and Usage</h4>
                <p>Subscribers must maintain valid credentials. Any script manipulation, bot subscriptions, or attempts to disrupt live-blog feeds will lead to immediate IP restrictions and account closures.</p>
            </div>
        </div>

        <div class="col-lg-4">
            @include('components.widgets', ['type' => 'newsletter'])
        </div>
    </div>

</div>
@endsection
