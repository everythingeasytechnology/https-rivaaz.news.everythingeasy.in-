<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- SEO and Discovery Meta Tags -->
    <title>@yield('title', 'Rivaaz Chronicle - Premium News Portal')</title>
    <meta name="description" content="@yield('meta_description', 'Rivaaz Chronicle is a premium, multi-tenant news portal SaaS delivering real-time coverage on Politics, Business, Tech, Sports, and Lifestyle.')">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Rivaaz Chronicle - Premium News Portal')">
    <meta property="og:description" content="@yield('meta_description', 'Real-time high-fidelity coverage.')">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:site_name" content="Rivaaz Chronicle">
    <meta name="twitter:card" content="summary_large_image">
    
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Inline theme script to prevent dark mode flicker -->
    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-bs-theme', savedTheme);
            } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
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
                <!-- Date and weather details -->
                <div class="col-md-5 d-flex align-items-center gap-3">
                    <span class="fw-semibold"><i class="far fa-calendar-alt text-primary me-1"></i> <span id="currentDate">Saturday, July 11, 2026</span></span>
                    <span class="text-secondary">|</span>
                    <span>
                        <i class="fas fa-cloud-sun text-warning me-1"></i> 
                        <span id="headerWeather">New Delhi, 34°C</span>
                    </span>
                </div>
                
                <!-- Breaking news ticker -->
                <div class="col-md-4">
                    <div class="breaking-ticker">
                        <span class="ticker-label">Breaking</span>
                        <div class="ticker-wrap">
                            <div class="ticker-content" id="breakingTicker">
                                <a href="/news/india-union-budget-2026-analysis">Union Budget 2026 outlines major green energy incentives & middle-class tax slab relief.</a>
                                <a href="/live-blog/india-union-budget-2026-analysis">Live Updates: Stock index Nifty hits record lifetime high post federal budget rally.</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Utilities: lang, social, auth, subscribe -->
                <div class="col-md-3">
                    <div class="header-actions">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link text-decoration-none dropdown-toggle p-0 text-reset fw-semibold" type="button" data-bs-toggle="dropdown">
                                EN
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                <li><a class="dropdown-item fw-medium active" href="#">English</a></li>
                                <li><a class="dropdown-item fw-medium" href="#">Hindi</a></li>
                                <li><a class="dropdown-item fw-medium" href="#">Spanish</a></li>
                            </ul>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <a href="#" class="text-reset hover-primary" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-reset hover-primary" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-reset hover-primary" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2 border-start ps-3 border-secondary-subtle">
                            <a href="#" class="text-reset text-decoration-none fw-semibold" data-bs-toggle="modal" data-bs-target="#authModal">Login</a>
                            <a href="#" class="btn btn-sm btn-primary rounded-pill fw-bold px-3">Subscribe</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- 2. Main Navigation Header -->
    <nav class="navbar navbar-expand-lg main-header py-3">
        <div class="container-xl">
            <a class="navbar-brand py-0" href="/">
                RIVAAZ<span>CHRONICLE</span>
            </a>
            
            <div class="d-flex d-lg-none align-items-center gap-2">
                <button class="btn btn-sm btn-outline-secondary border-0" id="mobileSearchBtn" data-bs-toggle="collapse" data-bs-target="#searchCollapse" aria-label="Search">
                    <i class="fas fa-search fs-5"></i>
                </button>
                <button class="btn btn-sm btn-outline-secondary border-0 theme-toggle-btn" aria-label="Toggle theme">
                    <i class="fas fa-moon fs-5"></i>
                </button>
                <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            
            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold text-uppercase">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a></li>
                    
                    <!-- India Dropdown -->
                    <li class="nav-item dropdown megamenu">
                        <a class="nav-link dropdown-toggle" href="/category/india" role="button" data-bs-toggle="dropdown">India</a>
                        <div class="dropdown-menu border-0 shadow">
                            <div class="row">
                                <div class="col-md-3">
                                    <h6 class="text-primary text-uppercase fw-bold mb-3">Subcategories</h6>
                                    <ul class="list-unstyled d-flex flex-column gap-2">
                                        <li><a href="/category/india" class="text-reset hover-primary text-decoration-none">National News</a></li>
                                        <li><a href="/category/india" class="text-reset hover-primary text-decoration-none">State Reports</a></li>
                                        <li><a href="/category/india" class="text-reset hover-primary text-decoration-none">Parliament Debates</a></li>
                                        <li><a href="/category/india" class="text-reset hover-primary text-decoration-none">Elections</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-5 border-start ps-4">
                                    <h6 class="text-secondary text-uppercase fw-bold mb-3">Trending in India</h6>
                                    <div class="news-horizontal-row py-0 border-0">
                                        <div class="row-content">
                                            <h6 class="row-title fw-bold"><a href="/news/india-union-budget-2026-analysis">Union Budget 2026: Key Allocations & Sectoral Impact Analysis</a></h6>
                                            <small class="text-muted">Politics • 2 hours ago</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 border-start ps-4 d-none d-md-block">
                                    <h6 class="text-secondary text-uppercase fw-bold mb-3">Live Feed</h6>
                                    <div class="alert alert-danger border-0 p-3 mb-0 rounded-4">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="badge bg-danger animate-pulse">LIVE</span>
                                            <span class="fw-bold text-uppercase fs-7">Budget Discussion</span>
                                        </div>
                                        <p class="mb-0 fs-7 text-dark-emphasis">Parliament proceeds with debate on standard deductions and startup capital limits.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <li class="nav-item"><a class="nav-link {{ request()->is('category/world') ? 'active' : '' }}" href="/category/world">World</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('category/politics') ? 'active' : '' }}" href="/category/politics">Politics</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('category/business') ? 'active' : '' }}" href="/category/business">Business</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('category/technology') ? 'active' : '' }}" href="/category/technology">Tech</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('category/sports') ? 'active' : '' }}" href="/category/sports">Sports</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('category/entertainment') ? 'active' : '' }}" href="/category/entertainment">Entertainment</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('category/health') ? 'active' : '' }}" href="/category/health">Health</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('category/lifestyle') ? 'active' : '' }}" href="/category/lifestyle">Lifestyle</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('photos') ? 'active' : '' }}" href="/photos">Photos</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('videos') ? 'active' : '' }}" href="/videos">Videos</a></li>
                </ul>
                
                <div class="d-none d-lg-flex align-items-center gap-3">
                    <!-- Search widget toggle -->
                    <div class="dropdown">
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
                    </div>
                    
                    <!-- Dark mode toggle -->
                    <button class="btn btn-link text-reset p-0 border-0 theme-toggle-btn" aria-label="Toggle theme">
                        <i class="fas fa-moon fs-5"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Search collapse -->
    <div class="collapse d-lg-none bg-body-tertiary border-bottom py-2 px-3" id="searchCollapse">
        <form action="/search" method="GET">
            <div class="input-group input-group-sm">
                <input type="text" name="q" class="form-control" placeholder="Search news...">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>

    <!-- 3. Main Content Grid -->
    <main class="py-4 fade-in-up">
        @yield('content')
    </main>

    <!-- 4. Footer Section -->
    <footer class="border-top py-5 bg-body-tertiary">
        <div class="container-xl">
            <div class="row g-4">
                <!-- Branding column -->
                <div class="col-lg-4">
                    <h5 class="headline-font fw-bold mb-3 text-primary">RIVAAZ CHRONICLE</h5>
                    <p class="text-muted small">An enterprise-level multi-tenant News Portal delivering cutting-edge journalism, real-time bulletins, and high-fidelity media galleries across devices.</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <!-- Category Links -->
                <div class="col-md-4 col-lg-2">
                    <h6 class="fw-bold text-uppercase mb-3">Categories</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="/category/india" class="text-reset text-decoration-none hover-primary">India News</a></li>
                        <li><a href="/category/world" class="text-reset text-decoration-none hover-primary">World Affairs</a></li>
                        <li><a href="/category/politics" class="text-reset text-decoration-none hover-primary">Politics</a></li>
                        <li><a href="/category/business" class="text-reset text-decoration-none hover-primary">Business & Finance</a></li>
                        <li><a href="/category/technology" class="text-reset text-decoration-none hover-primary">Technology & AI</a></li>
                    </ul>
                </div>
                
                <!-- Legal & Company Links -->
                <div class="col-md-4 col-lg-2">
                    <h6 class="fw-bold text-uppercase mb-3">Information</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="/about" class="text-reset text-decoration-none hover-primary">About Us</a></li>
                        <li><a href="/contact" class="text-reset text-decoration-none hover-primary">Advertise with Us</a></li>
                        <li><a href="/privacy" class="text-reset text-decoration-none hover-primary">Privacy Policy</a></li>
                        <li><a href="/terms" class="text-reset text-decoration-none hover-primary">Terms of Service</a></li>
                        <li><a href="/contact" class="text-reset text-decoration-none hover-primary">Contact & Support</a></li>
                    </ul>
                </div>
                
                <!-- App Links / Newsletter -->
                <div class="col-md-4 col-lg-4">
                    <h6 class="fw-bold text-uppercase mb-3">Download Our App</h6>
                    <p class="text-muted small">Stay updated on the go with real-time push alerts, offline articles read-time, and video digests.</p>
                    <div class="d-flex gap-2 mb-3">
                        <a href="#" class="btn btn-dark btn-sm rounded-3 py-2 px-3 d-flex align-items-center gap-2">
                            <i class="fab fa-apple fs-4"></i>
                            <span class="text-start" style="line-height:1.1;">
                                <small class="text-muted fs-8 d-block">Download on the</small>
                                <span class="fw-bold fs-7">App Store</span>
                            </span>
                        </a>
                        <a href="#" class="btn btn-dark btn-sm rounded-3 py-2 px-3 d-flex align-items-center gap-2">
                            <i class="fab fa-google-play fs-4"></i>
                            <span class="text-start" style="line-height:1.1;">
                                <small class="text-muted fs-8 d-block">Get it on</small>
                                <span class="fw-bold fs-7">Google Play</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            
            <hr class="my-4 border-secondary-subtle">
            
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-muted small">&copy; 2026 Rivaaz Chronicle News Portal SaaS. All Rights Reserved. Designed in high fidelity.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <a href="/archive" class="text-reset text-decoration-none hover-primary small me-3"><i class="fas fa-history me-1"></i> Archive</a>
                    <a href="/rss" class="text-reset text-decoration-none hover-primary small"><i class="fas fa-rss text-warning me-1"></i> RSS Feed</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- 5. Sticky Bottom Navigation (Mobile Only) -->
    <nav class="mobile-bottom-nav d-lg-none">
        <a href="/" class="bottom-nav-item {{ request()->is('/') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="/category/india" class="bottom-nav-item {{ request()->is('category/*') ? 'active' : '' }}">
            <i class="fas fa-list-ul"></i>
            <span>Categories</span>
        </a>
        <a href="/live-blog/india-union-budget-2026-analysis" class="bottom-nav-item">
            <i class="fas fa-broadcast-tower text-danger animate-pulse"></i>
            <span>Live Blog</span>
        </a>
        <a href="/videos" class="bottom-nav-item {{ request()->is('videos') ? 'active' : '' }}">
            <i class="fas fa-play-circle"></i>
            <span>Videos</span>
        </a>
        <a href="/photos" class="bottom-nav-item {{ request()->is('photos') ? 'active' : '' }}">
            <i class="fas fa-images"></i>
            <span>Photos</span>
        </a>
    </nav>

    <!-- Authentication Modal (Mock) -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Sign In to Rivaaz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <form onsubmit="event.preventDefault(); alert('Authentication simulated successfully!'); bootstrap.Modal.getInstance(document.getElementById('authModal')).hide();">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Email address</label>
                            <input type="email" class="form-control rounded-3" placeholder="name@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Password</label>
                            <input type="password" class="form-control rounded-3" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold mt-2">Log In</button>
                    </form>
                    <div class="text-center mt-3">
                        <p class="small text-muted mb-0">Don't have an account? <a href="#" class="fw-bold">Register</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
