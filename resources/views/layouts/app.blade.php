<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Comprehensive SEO and Social Sharing (OpenGraph & Twitter Card) Meta Tags -->
    <title>@yield('title', ($siteSettings->site_name ?? 'The Uttarakhand Now') . ' - Premium News Portal')</title>
    <meta name="description" content="@yield('meta_description', $siteSettings->footer_text ?? 'The Uttarakhand Now is a premium, multi-tenant news portal delivering real-time coverage.')">
    <meta name="keywords" content="@yield('meta_keywords', 'news, india, updates, politics, business, tech, sports, entertainment, uttarakhand news')">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="{{ request()->url() }}">

    <!-- OpenGraph Meta Tags for WhatsApp, Facebook, LinkedIn, Telegram Rich Cards -->
    <meta property="og:site_name" content="{{ $siteSettings->site_name ?? 'The Uttarakhand Now' }}">
    <meta property="og:locale" content="hi_IN">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:title" content="@yield('title', ($siteSettings->site_name ?? 'The Uttarakhand Now'))">
    <meta property="og:description" content="@yield('meta_description', $siteSettings->footer_text ?? 'Real-time high-fidelity news coverage.')">
    @php
        $shareImage = trim(View::yieldContent('meta_image'));
        if (empty($shareImage)) {
            $shareImage = !empty($siteSettings->logo_path) ? asset($siteSettings->logo_path) : asset('/logo.jpeg');
        } elseif (!str_starts_with($shareImage, 'http://') && !str_starts_with($shareImage, 'https://')) {
            $shareImage = asset($shareImage);
        }
    @endphp
    <meta property="og:image" content="{{ $shareImage }}">
    <meta property="og:image:secure_url" content="{{ $shareImage }}">
    <meta property="og:image:alt" content="@yield('title', ($siteSettings->site_name ?? 'The Uttarakhand Now'))">

    <!-- Twitter / X Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@uttarakhandnow">
    <meta name="twitter:creator" content="@uttarakhandnow">
    <meta name="twitter:title" content="@yield('title', ($siteSettings->site_name ?? 'The Uttarakhand Now'))">
    <meta name="twitter:description" content="@yield('meta_description', $siteSettings->footer_text ?? 'Real-time high-fidelity news coverage.')">
    <meta name="twitter:image" content="{{ $shareImage }}">
    <meta name="twitter:image:alt" content="@yield('title', ($siteSettings->site_name ?? 'The Uttarakhand Now'))">

    <!-- FontAwesome 6.5.2 for Latest X / Twitter & Social Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- Inline theme script to prevent dark mode flicker -->
    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-bs-theme', savedTheme);
            } else {
                document.documentElement.setAttribute('data-bs-theme', 'light');
            }
        })();
    </script>

    <!-- Vite compiled assets -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @yield('styles')

    <style>
        .theme-toggle-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            color: inherit !important;
            border-radius: 50% !important;
            width: 36px;
            height: 36px;
            padding: 0 !important;
            text-decoration: none !important;
            outline: none !important;
            transition: transform 0.2s ease, background-color 0.2s ease !important;
        }
        .theme-toggle-btn:hover,
        .theme-toggle-btn:focus,
        .theme-toggle-btn:active,
        .theme-toggle-btn:focus-visible {
            background-color: rgba(128, 128, 128, 0.12) !important;
            color: var(--bs-primary, #E50000) !important;
            transform: scale(1.08);
            box-shadow: none !important;
            outline: none !important;
        }
        .header-search-toggle {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        .header-search-menu {
            width: min(340px, calc(100vw - 2rem));
        }
        .mobile-header-search {
            border-top: 1px solid var(--bs-border-color);
            background: var(--bs-body-bg);
        }
        .header-search-form .form-control {
            min-width: 0;
        }
    </style>

    <!-- Google AdSense Direct Script / Verification -->
    @if(!empty($siteSettings->adsense_script) && ($siteSettings->adsense_enabled ?? true))
        {!! $siteSettings->adsense_script !!}
    @endif
</head>
<body>

    <!-- Reading Progress Bar (For Single News pages) -->
    <div class="reading-progress-container d-none" id="readingProgress">
        <div class="progress-bar" id="readingProgressBar"></div>
    </div>

    <!-- Google AdSense Header Ad Banner -->
    @if(!empty($siteSettings->adsense_header_code) && ($siteSettings->adsense_enabled ?? true))
        <div class="container-xl my-2 text-center adsense-header-container">
            {!! $siteSettings->adsense_header_code !!}
        </div>
    @endif

    <!-- 1. Top Header -->
    <header class="top-header d-none d-lg-block">
        <div class="container-xl">
            <div class="row align-items-center">
                <!-- Date, weather & Breaking news details -->
                <div class="col-lg-9 d-flex align-items-center gap-3">
                    <span class="fw-semibold text-nowrap"><i class="far fa-calendar-alt text-primary me-1"></i> <span id="currentDate">Saturday, July 11, 2026</span></span>
                    <span class="text-secondary">|</span>
                    <span class="text-nowrap">
                        <i class="fas fa-map-marker-alt text-danger me-1"></i> 
                        <span class="fw-semibold">उत्तराखंड</span>
                    </span>
                    @if(isset($breakingNews) && $breakingNews->count() > 0)
                    <span class="text-secondary">|</span>
                    <div class="breaking-ticker flex-grow-1" style="max-width: none;">
                        <span class="ticker-label">ब्रेकिंग</span>
                        <div class="ticker-wrap">
                            <div class="ticker-content" id="breakingTicker">
                                @foreach($breakingNews as $art)
                                    <a href="/news/{{ $art->slug }}">{{ $art->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Utilities: lang, social, auth, subscribe -->
                <div class="col-lg-3">
                    <div class="header-actions">
                        <!-- <div class="dropdown">
                            <button class="btn btn-sm btn-link text-decoration-none dropdown-toggle p-0 text-reset fw-semibold" type="button" data-bs-toggle="dropdown">
                                EN
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                <li><a class="dropdown-item fw-medium active" href="#">English</a></li>
                                <li><a class="dropdown-item fw-medium" href="#">Hindi</a></li>
                                <li><a class="dropdown-item fw-medium" href="#">Spanish</a></li>
                            </ul>
                        </div> -->
                        
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ $siteSettings->social_facebook ?? '#' }}" target="_blank" class="text-reset hover-primary" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $siteSettings->social_twitter ?? '#' }}" target="_blank" class="text-reset hover-primary" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="{{ $siteSettings->social_instagram ?? '#' }}" target="_blank" class="text-reset hover-primary" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2 border-start ps-3 border-secondary-subtle">
                            <button class="btn btn-link text-reset p-0 border-0 theme-toggle-btn me-2" aria-label="Toggle theme">
                                <i class="fas fa-moon fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- 2. Main Navigation Header -->
    <nav class="navbar navbar-expand-lg main-header py-2 py-lg-3">
        <div class="container-xl">
            <a class="navbar-brand py-0 d-flex align-items-center" href="/">
                <img src="{{ $siteSettings->logo_path ?? '/logo.jpeg' }}" alt="{{ $siteSettings->site_name ?? 'The Uttarakhand Now' }}" style="height: 42px; width: auto; max-height: 42px; border-radius: 4px;">
            </a>
            
            <div class="d-flex d-lg-none align-items-center gap-2">
                <button class="btn btn-link text-reset border-0 p-1 header-search-toggle" id="mobileSearchBtn" type="button" data-bs-toggle="collapse" data-bs-target="#mobileHeaderSearch" aria-controls="mobileHeaderSearch" aria-expanded="false" aria-label="समाचार खोजें">
                    <i class="fas fa-search fs-6"></i>
                </button>
                <button class="btn btn-link text-reset p-1 border-0 theme-toggle-btn" aria-label="Toggle theme">
                    <i class="fas fa-moon fs-5"></i>
                </button>
                <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            
            <div class="collapse navbar-collapse" id="mainMenu">
                <!-- Mobile Menu Drawer Header -->
                <div class="d-lg-none d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <span class="fw-bold fs-5 text-body">नेविगेशन मेनू</span>
                    <button class="btn btn-link text-reset p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-label="Close menu">
                        <i class="fas fa-times fs-4"></i>
                    </button>
                </div>
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold text-uppercase">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">होम</a></li>
                    
                    @if(isset($navbarCategories))
                        @foreach($navbarCategories as $navCat)
                            @if($navCat->subcategories->count() > 0)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ request()->is('category/' . $navCat->slug) || request()->is('category/' . $navCat->slug . '/*') ? 'active' : '' }}" href="/category/{{ $navCat->slug }}" role="button" data-bs-toggle="dropdown">{{ $navCat->name }}</a>
                                    <ul class="dropdown-menu border-0 shadow">
                                        @foreach($navCat->subcategories as $navSub)
                                            <li><a href="/category/{{ $navCat->slug }}/{{ $navSub->slug }}" class="dropdown-item">{{ $navSub->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item"><a class="nav-link {{ request()->is('category/' . $navCat->slug) ? 'active' : '' }}" href="/category/{{ $navCat->slug }}">{{ $navCat->name }}</a></li>
                            @endif
                        @endforeach
                    @else
                        <li class="nav-item"><a class="nav-link {{ request()->is('category/india') ? 'active' : '' }}" href="/category/india">भारत</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->is('category/world') ? 'active' : '' }}" href="/category/world">विदेश</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->is('category/politics') ? 'active' : '' }}" href="/category/politics">राजनीति</a></li>
                    @endif
                    
                    <li class="nav-item"><a class="nav-link {{ request()->is('videos') ? 'active' : '' }}" href="/videos">वीडियो</a></li>
                </ul>
                
                <div class="d-none d-lg-flex align-items-center gap-3">
                    <!-- Search widget toggle -->
                    <div class="dropdown">
                        <button class="btn btn-link text-reset p-0 border-0 header-search-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="desktopSearchBtn" aria-label="समाचार खोजें">
                            <i class="fas fa-search fs-5"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-3 header-search-menu">
                            <form action="{{ route('search') }}" method="GET" class="header-search-form">
                                <label for="desktopNewsSearch" class="form-label small fw-bold">समाचार खोजें</label>
                                <div class="input-group">
                                    <input id="desktopNewsSearch" type="search" name="q" class="form-control border-secondary-subtle shadow-none" placeholder="खबर का नाम लिखें..." value="{{ request('q') }}" maxlength="100" required autocomplete="off">
                                    <button class="btn btn-primary" type="submit" aria-label="खोजें"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="collapse d-lg-none mobile-header-search" id="mobileHeaderSearch">
            <div class="container-xl py-2">
                <form action="{{ route('search') }}" method="GET" class="header-search-form">
                    <label for="mobileNewsSearch" class="visually-hidden">समाचार खोजें</label>
                    <div class="input-group">
                        <input id="mobileNewsSearch" type="search" name="q" class="form-control border-secondary-subtle shadow-none" placeholder="समाचार खोजें..." value="{{ request('q') }}" maxlength="100" required autocomplete="off">
                        <button class="btn btn-primary px-3" type="submit" aria-label="खोजें"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    
    <!-- Manual Top Leaderboard Banner Ad -->
    @if(!empty($siteSettings) && ($siteSettings->ad_top_banner_enabled ?? false) && (!empty($siteSettings->ad_top_banner_image) || !empty($siteSettings->ad_top_banner_code)))
        <div class="container-xl pt-3 pb-1 text-center manual-ad-top-banner">
            <div class="position-relative d-inline-block w-100" style="max-width: 970px;">
                <div class="d-flex justify-content-center align-items-center mb-1 px-1">
                    <span class="text-uppercase text-muted fw-semibold" style="font-size: 0.60rem; letter-spacing: 0.5px;">विज्ञापन / ADVERTISEMENT</span>
                </div>
                @if(!empty($siteSettings->ad_top_banner_code))
                    <div class="overflow-hidden rounded-3 border bg-body-tertiary text-center p-1 shadow-sm">
                        {!! $siteSettings->ad_top_banner_code !!}
                    </div>
                @elseif(!empty($siteSettings->ad_top_banner_image))
                    <a href="{{ $siteSettings->ad_top_banner_link ?: '#' }}" target="_blank" rel="noopener noreferrer" class="d-inline-block overflow-hidden rounded-3 border shadow-sm bg-body-tertiary">
                        <img src="{{ $siteSettings->ad_top_banner_image }}" alt="Top Banner Advertisement" class="img-fluid" style="max-height: 120px; object-fit: contain;">
                    </a>
                @endif
            </div>
        </div>
    @endif

    <!-- 3. Main Content Grid -->
    <main class="py-4 fade-in-up">
        @yield('content')
    </main>

    <!-- 4. Footer Section -->
    <footer class="border-top py-5 bg-body-tertiary">
        <div class="container-xl">
            <div class="row g-4">
                <!-- Branding column -->
                <div class="col-lg-6">
                    <img src="{{ $siteSettings->logo_path ?? '/logo.jpeg' }}" alt="{{ $siteSettings->site_name ?? 'The Uttarakhand Now' }}" style="height: 45px; width: auto; max-height: 45px; border-radius: 4px;" class="mb-3">
                    <p class="text-muted small">{{ $siteSettings->footer_text ?? 'An enterprise-level news portal.' }}</p>
                    <div class="d-flex gap-2">
                        <a href="{{ $siteSettings->social_facebook ?? '#' }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ $siteSettings->social_twitter ?? '#' }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fab fa-twitter"></i></a>
                        <a href="{{ $siteSettings->social_linkedin ?? '#' }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fab fa-linkedin-in"></i></a>
                        <a href="{{ $siteSettings->social_instagram ?? '#' }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <!-- Category Links -->
                <div class="col-md-6 col-lg-3">
                    <h6 class="fw-bold text-uppercase mb-3">श्रेणियाँ</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        @if(isset($navbarCategories))
                            @foreach($navbarCategories->take(5) as $cat)
                                <li><a href="/category/{{ $cat->slug }}" class="text-reset text-decoration-none hover-primary">{{ $cat->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                
                <!-- Legal & Company Links -->
                <div class="col-md-6 col-lg-3">
                    <h6 class="fw-bold text-uppercase mb-3">जानकारी</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="/about" class="text-reset text-decoration-none hover-primary">हमारे बारे में</a></li>
                        <li><a href="/contact" class="text-reset text-decoration-none hover-primary">हमारे साथ विज्ञापन करें</a></li>
                        <li><a href="/privacy" class="text-reset text-decoration-none hover-primary">गोपनीयता नीति</a></li>
                        <li><a href="/terms" class="text-reset text-decoration-none hover-primary">सेवा की शर्तें</a></li>
                        <li><a href="/contact" class="text-reset text-decoration-none hover-primary">संपर्क और सहायता</a></li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-4 border-secondary-subtle">
            
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-muted small">&copy; {{ date('Y') }} {{ $siteSettings->site_name ?? 'द उत्तराखंड नाउ' }}। सर्वाधिकार सुरक्षित।</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <a href="/archive" class="text-reset text-decoration-none hover-primary small me-3"><i class="fas fa-history me-1"></i> अभिलेखागार</a>
                    <a href="/rss" class="text-reset text-decoration-none hover-primary small"><i class="fas fa-rss text-warning me-1"></i> आरएसएस फीड</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- 5. Sticky Bottom Navigation (Mobile Only) -->
    <nav class="mobile-bottom-nav d-lg-none">
        <a href="/" class="bottom-nav-item {{ request()->is('/') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>होम</span>
        </a>
        <a href="/category/india" class="bottom-nav-item {{ request()->is('category/*') ? 'active' : '' }}">
            <i class="fas fa-list-ul"></i>
            <span>श्रेणियाँ</span>
        </a>
        <a href="/live-blog/india-union-budget-2026-analysis" class="bottom-nav-item">
            <i class="fas fa-broadcast-tower text-danger animate-pulse"></i>
            <span>लाइव ब्लॉग</span>
        </a>
        <a href="/videos" class="bottom-nav-item {{ request()->is('videos') ? 'active' : '' }}">
            <i class="fas fa-play-circle"></i>
            <span>वीडियो</span>
        </a>
    </nav>

    <!-- First-visit newsletter subscription popup -->
    <div class="modal fade subscription-modal" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                <button type="button" class="btn-close subscription-close" data-bs-dismiss="modal" aria-label="बंद करें"></button>
                <div class="modal-body p-4 p-sm-5 text-center">
                    <div class="subscription-icon mx-auto mb-3">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <h2 class="h4 fw-bold mb-2" id="subscriptionModalLabel">हर बड़ी खबर सबसे पहले पाएं</h2>
                    <p class="text-muted mb-4">उत्तराखंड और देश की महत्वपूर्ण खबरें सीधे अपने इनबॉक्स में पाएं।</p>

                    <form id="subscriptionForm" action="{{ route('subscribe.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="input-group subscription-input-group">
                            <input type="email" name="email" id="subscriptionEmail" class="form-control" placeholder="आपका ईमेल पता" autocomplete="email" required aria-label="ईमेल पता">
                            <button class="btn btn-primary fw-bold px-4" type="submit" id="subscriptionSubmit">सब्सक्राइब करें</button>
                        </div>
                        <div class="small mt-2 text-start d-none" id="subscriptionMessage" role="alert"></div>
                    </form>
                    <p class="text-muted mt-3 mb-0" style="font-size: 0.72rem;">कोई स्पैम नहीं। आप कभी भी सदस्यता छोड़ सकते हैं।</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Authentication Modal (Mock) -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">उत्तराखंड नाउ में साइन इन करें</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <form onsubmit="event.preventDefault(); alert('Authentication simulated successfully! Redirecting to SaaS Admin Panel...'); window.location.href = '/admin';">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">ईमेल पता</label>
                            <input type="email" class="form-control rounded-3" placeholder="name@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">पासवर्ड</label>
                            <input type="password" class="form-control rounded-3" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold mt-2">लॉग इन</button>
                    </form>
                    <div class="text-center mt-3">
                        <p class="small text-muted mb-0">क्या आपका खाता नहीं है? <a href="#" class="fw-bold">पंजीकरण करें</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Share Toast Notification -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
        <div id="shareToast" class="toast align-items-center text-bg-dark border-0 rounded-4 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i class="fas fa-check-circle text-success fs-5"></i>
                    <span id="shareToastMessage">खबर का लिंक कॉपी कर लिया गया है!</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Global Share Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.copy-link-btn');
                if (!btn) return;
                
                e.preventDefault();
                e.stopPropagation();
                
                const url = btn.getAttribute('data-url') || window.location.href;
                const title = btn.getAttribute('data-title') || document.title;
                
                // If on mobile and user clicked a general share button
                if (navigator.share && window.innerWidth <= 768 && btn.classList.contains('prefer-native-share')) {
                    navigator.share({
                        title: title,
                        url: url
                    }).catch(function() {
                        copyToClipboard(url);
                    });
                } else {
                    copyToClipboard(url);
                }
            });
            
            function copyToClipboard(text) {
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text).then(showToast).catch(function() {
                        fallbackCopy(text);
                    });
                } else {
                    fallbackCopy(text);
                }
            }
            
            function fallbackCopy(text) {
                const textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.position = "fixed";
                textArea.style.opacity = "0";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    showToast();
                } catch (err) {
                    // ignore
                }
                document.body.removeChild(textArea);
            }
            
            function showToast() {
                const toastEl = document.getElementById('shareToast');
                if (toastEl && typeof bootstrap !== 'undefined' && bootstrap.Toast) {
                    const toast = new bootstrap.Toast(toastEl, { delay: 2500 });
                    toast.show();
                } else {
                    alert('खबर का लिंक कॉपी हो गया है!');
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalElement = document.getElementById('subscriptionModal');
            const form = document.getElementById('subscriptionForm');
            if (!modalElement || !form || typeof bootstrap === 'undefined') return;

            const subscribedKey = 'uttarakhand_now_newsletter_subscribed';
            const dismissedKey = 'uttarakhand_now_newsletter_dismissed_at';
            const dismissalPeriod = 7 * 24 * 60 * 60 * 1000;
            const message = document.getElementById('subscriptionMessage');
            const submitButton = document.getElementById('subscriptionSubmit');
            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
            let subscriptionCompleted = false;

            function storageGet(key) {
                try { return localStorage.getItem(key); } catch (error) { return null; }
            }

            function storageSet(key, value) {
                try { localStorage.setItem(key, value); } catch (error) { /* Storage may be disabled. */ }
            }

            const subscribed = storageGet(subscribedKey) === 'true';
            const dismissedAt = Number(storageGet(dismissedKey) || 0);
            const recentlyDismissed = dismissedAt && (Date.now() - dismissedAt < dismissalPeriod);

            if (!subscribed && !recentlyDismissed) {
                window.setTimeout(function () { modal.show(); }, 1500);
            }

            modalElement.addEventListener('hidden.bs.modal', function () {
                if (!subscriptionCompleted && storageGet(subscribedKey) !== 'true') {
                    storageSet(dismissedKey, String(Date.now()));
                }
            });

            form.addEventListener('submit', async function (event) {
                event.preventDefault();
                message.classList.add('d-none');
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span> कृपया प्रतीक्षा करें';

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: new FormData(form)
                    });
                    const data = await response.json();

                    if (!response.ok) {
                        const emailError = data.errors && data.errors.email ? data.errors.email[0] : null;
                        throw new Error(emailError || data.message || 'सब्सक्रिप्शन पूरा नहीं हो सका।');
                    }

                    subscriptionCompleted = true;
                    storageSet(subscribedKey, 'true');
                    storageSet(dismissedKey, String(Date.now()));
                    message.textContent = data.message;
                    message.className = 'small mt-3 text-success fw-semibold';
                    form.querySelector('.subscription-input-group').classList.add('d-none');
                    window.setTimeout(function () { modal.hide(); }, 1600);
                } catch (error) {
                    message.textContent = error.message || 'कुछ गलत हुआ। कृपया दोबारा कोशिश करें।';
                    message.className = 'small mt-2 text-danger text-start';
                    submitButton.disabled = false;
                    submitButton.textContent = 'सब्सक्राइब करें';
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
