<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- SEO and Discovery Meta Tags -->
    <title>@yield('title', ($siteSettings->site_name ?? 'The Uttarakhand Now') . ' - Premium News Portal')</title>
    <meta name="description" content="@yield('meta_description', $siteSettings->footer_text ?? 'The Uttarakhand Now is a premium, multi-tenant news portal SaaS delivering real-time coverage on Politics, Business, Tech, Sports, and Lifestyle.')">
    <meta name="keywords" content="@yield('meta_keywords', 'news, india, updates, politics, business, tech, sports, entertainment')">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', ($siteSettings->site_name ?? 'The Uttarakhand Now') . ' - Premium News Portal')">
    <meta property="og:description" content="@yield('meta_description', 'Real-time high-fidelity coverage.')">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:site_name" content="{{ $siteSettings->site_name ?? 'The Uttarakhand Now' }}">
    <meta name="twitter:card" content="summary_large_image">
    
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
</head>
<body>

    <!-- Reading Progress Bar (For Single News pages) -->
    <div class="reading-progress-container d-none" id="readingProgress">
        <div class="progress-bar" id="readingProgressBar"></div>
    </div>

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
                <!-- <button class="btn btn-sm btn-outline-secondary border-0" id="mobileSearchBtn" data-bs-toggle="collapse" data-bs-target="#searchCollapse" aria-label="Search">
                    <i class="fas fa-search fs-6"></i>
                </button> -->
                <button class="btn btn-sm btn-outline-secondary border-0 theme-toggle-btn" aria-label="Toggle theme">
                    <i class="fas fa-moon fs-6"></i>
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
                    <!-- <div class="dropdown">
                        <button class="btn btn-link text-reset p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="desktopSearchBtn">
                            <i class="fas fa-search fs-5"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-3" style="width: 320px;">
                            <form action="/search" method="GET">
                                <div class="input-group">
                                    <input type="text" name="q" class="form-control border-secondary-subtle shadow-none" placeholder="Search articles...">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div> -->
                    

                </div>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Search collapse -->


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

    <!-- Authentication Modal (Mock) -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">रीवाज़ में साइन इन करें</h5>
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

</body>
</html>
