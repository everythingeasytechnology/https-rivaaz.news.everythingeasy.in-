@extends('layouts.admin')

@section('title', 'Admin Dashboard - Rivaaz News SaaS')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Header Summary -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="m-0 fw-bold">Executive Dashboard</h3>
            <p class="text-muted small m-0">Overview of tenant Node metrics, analytics, and content channels.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2 border-secondary-subtle" onclick="location.reload();">
                <i class="fa-solid fa-arrows-rotate"></i> Refresh Metrics
            </button>
            <button class="btn btn-sm btn-primary d-flex align-items-center gap-2" onclick="alert('Generating analytics export PDF...');">
                <i class="fa-solid fa-download"></i> Export PDF
            </button>
        </div>
    </div>

    <!-- 1. Stats Counter Widgets -->
    <div class="row g-3 mb-4">
        
        <!-- Today's Visitors -->
        <div class="col-sm-6 col-md-3">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small text-uppercase fw-bold">Today's Visitors</span>
                    <span class="badge bg-success-subtle text-success fs-9">+12.4%</span>
                </div>
                <h3 class="fw-bold mb-1">24,850</h3>
                <small class="text-muted" style="font-size: 0.75rem;"><i class="fa-solid fa-arrow-trend-up text-success"></i> vs 22,100 yesterday</small>
            </div>
        </div>

        <!-- Monthly Visitors -->
        <div class="col-sm-6 col-md-3">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small text-uppercase fw-bold">Monthly Visitors</span>
                    <span class="badge bg-success-subtle text-success fs-9">+8.2%</span>
                </div>
                <h3 class="fw-bold mb-1">624,300</h3>
                <small class="text-muted" style="font-size: 0.75rem;"><i class="fa-solid fa-arrow-trend-up text-success"></i> vs 577,000 last month</small>
            </div>
        </div>

        <!-- Realtime active visitors -->
        <div class="col-sm-6 col-md-3">
            <div class="card border border-danger-subtle bg-danger bg-opacity-10 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-danger small text-uppercase fw-bold"><i class="fa-solid fa-circle animate-pulse me-1"></i> Active Now</span>
                    <span class="badge bg-danger text-white fs-9 animate-pulse">Live</span>
                </div>
                <h3 class="fw-bold text-danger mb-1" id="activeVisitorsCount">184</h3>
                <small class="text-danger-emphasis" style="font-size: 0.75rem;">Real-time concurrent visitors</small>
            </div>
        </div>

        <!-- Published Articles -->
        <div class="col-sm-6 col-md-3">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small text-uppercase fw-bold">Articles Index</span>
                    <span class="text-muted fs-8">SaaS database</span>
                </div>
                <h3 class="fw-bold mb-1">1,482</h3>
                <small class="text-muted" style="font-size: 0.75rem;"><strong class="text-dark">27</strong> Drafts | <strong class="text-danger">15</strong> Pending Review</small>
            </div>
        </div>

    </div>

    <!-- 2. Revenue Summary Row -->
    <div class="row g-3 mb-4">
        
        <!-- Revenue Details -->
        <div class="col-lg-8">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h5 class="fw-bold m-0">Monthly Revenue Tracker</h5>
                        <small class="text-muted">Consolidated SaaS revenue from subscriptions and ad networks.</small>
                    </div>
                    <h4 class="fw-bold text-success m-0">$8,420</h4>
                </div>
                
                <!-- Mock Graph Chart Details -->
                <div class="bg-body-tertiary rounded-3 p-4 border border-secondary-subtle text-center position-relative mb-3" style="height: 180px;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <i class="fa-solid fa-chart-line fs-1 text-muted opacity-50 mb-2"></i>
                        <span class="d-block text-muted small fw-semibold">Interactive Revenue Graph Placeholder</span>
                    </div>
                    <!-- Mock Lines rendering with pure CSS bars for mock aesthetic -->
                    <div class="d-flex justify-content-between align-items-end h-100 px-3">
                        <div class="bg-primary bg-opacity-20 rounded" style="width: 8%; height: 35%;"></div>
                        <div class="bg-primary bg-opacity-20 rounded" style="width: 8%; height: 50%;"></div>
                        <div class="bg-primary bg-opacity-20 rounded" style="width: 8%; height: 45%;"></div>
                        <div class="bg-primary bg-opacity-20 rounded" style="width: 8%; height: 65%;"></div>
                        <div class="bg-primary bg-opacity-20 rounded" style="width: 8%; height: 80%;"></div>
                        <div class="bg-primary rounded animate-pulse" style="width: 8%; height: 95%;"></div>
                    </div>
                </div>

                <div class="row text-center g-2 small">
                    <div class="col-6 border-end border-secondary-subtle">
                        <span class="text-muted d-block">Advertisement Networks</span>
                        <strong class="fs-6 text-dark">$5,240</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-muted d-block">Paid Subscription Plans</span>
                        <strong class="fs-6 text-dark">$3,180</strong>
                    </div>
                </div>

            </div>
        </div>

        <!-- Traffic & Country Analytics -->
        <div class="col-lg-4">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 h-100">
                <h5 class="fw-bold mb-3">Top Country Channels</h5>
                
                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="small"><i class="fa-solid fa-flag text-primary me-2"></i> India</span>
                        <span class="fw-bold small">142,400 (62%)</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar" role="progressbar" style="width: 62%;" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <span class="small"><i class="fa-solid fa-flag text-secondary me-2"></i> United States</span>
                        <span class="fw-bold small">48,200 (21%)</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 21%;" aria-valuenow="21" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <span class="small"><i class="fa-solid fa-flag text-secondary me-2"></i> United Kingdom</span>
                        <span class="fw-bold small">18,500 (8%)</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 8%;" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <!-- Device distribution details -->
                <div class="border-top border-secondary-subtle pt-3">
                    <h6 class="fw-bold small mb-2">Device Distribution</h6>
                    <div class="d-flex gap-3 text-center small text-muted">
                        <div class="flex-fill"><i class="fa-solid fa-mobile-screen-button"></i> Mobile <strong class="d-block text-dark">74%</strong></div>
                        <div class="flex-fill"><i class="fa-solid fa-desktop"></i> Desktop <strong class="d-block text-dark">22%</strong></div>
                        <div class="flex-fill"><i class="fa-solid fa-tablet-screen-button"></i> Tablet <strong class="d-block text-dark">4%</strong></div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- 3. Tables / Rankings Area -->
    <div class="row g-3">
        
        <!-- Most Read Articles -->
        <div class="col-md-6 col-lg-8">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3">Most Read Articles</h5>
                <div class="table-responsive">
                    <table class="table align-middle table-hover small">
                        <thead>
                            <tr class="text-muted">
                                <th>Article Title</th>
                                <th>Category</th>
                                <th>Views</th>
                                <th>Author</th>
                                <th>Trending</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold text-truncate" style="max-width: 230px;"><a href="#" class="text-reset text-decoration-none">Narottam Mishra Meets MP BJP Leadership After Datia Snub</a></td>
                                <td><span class="badge bg-secondary-subtle text-secondary text-uppercase fs-9">India</span></td>
                                <td>4,850</td>
                                <td>Rajesh Sharma</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" checked onchange="showNotification('Trending flag toggled for Indian politics updates')">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-truncate" style="max-width: 230px;"><a href="#" class="text-reset text-decoration-none">Silicon Foundries Commit Bilateral Manufacturing expansion</a></td>
                                <td><span class="badge bg-secondary-subtle text-secondary text-uppercase fs-9">Tech</span></td>
                                <td>3,120</td>
                                <td>Ananya S.</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" checked onchange="showNotification('Trending flag toggled for Silicon Foundries news')">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-truncate" style="max-width: 230px;"><a href="#" class="text-reset text-decoration-none">Budget Provisions for Green Hydrogen Investment Initiatives</a></td>
                                <td><span class="badge bg-secondary-subtle text-secondary text-uppercase fs-9">Business</span></td>
                                <td>2,450</td>
                                <td>Vikram M.</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" onchange="showNotification('Trending flag toggled for Hydrogen investment logs')">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Contributors / Categories -->
        <div class="col-md-6 col-lg-4">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 h-100">
                <h5 class="fw-bold mb-3">Top Contributors</h5>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=80&q=80" alt="Author" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-0 small fw-bold">Rajesh Sharma</h6>
                            <small class="text-muted">Chief Reporter</small>
                        </div>
                        <span class="badge bg-primary-subtle text-primary fw-bold">42 Posts</span>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=80&q=80" alt="Author" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-0 small fw-bold">Vikram Malhotra</h6>
                            <small class="text-muted">Business Writer</small>
                        </div>
                        <span class="badge bg-primary-subtle text-primary fw-bold">28 Posts</span>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=80&q=80" alt="Author" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-0 small fw-bold">Ananya Sen</h6>
                            <small class="text-muted">Tech Editor</small>
                        </div>
                        <span class="badge bg-primary-subtle text-primary fw-bold">24 Posts</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
