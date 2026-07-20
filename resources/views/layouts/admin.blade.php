<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Rivaaz Chronicle</title>
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite assets -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @yield('styles')
    
    <style>
        body {
            background-color: var(--bs-body-bg);
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
        
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #111418;
            color: #fff;
            padding-top: 20px;
            z-index: 100;
        }

        [data-bs-theme="dark"] .sidebar {
            background-color: #0b0d10;
            border-right: 1px solid #1a1e24;
        }
        
        .sidebar-brand {
            padding: 10px 24px;
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-menu {
            margin-top: 30px;
            list-style: none;
            padding-left: 0;
        }
        
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: #a0aec0;
            text-decoration: none;
            font-weight: 550;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu li a:hover,
        .sidebar-menu li.active a {
            color: #fff;
            background-color: rgba(255,255,255,0.05);
            border-left-color: var(--bs-primary);
        }
        
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--bs-border-color);
        }
        
        .admin-card {
            border-radius: 12px;
            border: 1px solid var(--bs-border-color);
            background-color: var(--bs-body-bg);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03), 0 2px 4px -1px rgba(0,0,0,0.02);
            padding: 24px;
        }
        
        @media (max-width: 991.98px) {
            .sidebar {
                display: none;
            }
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-newspaper text-primary"></i>
            <span>Rivaaz Admin</span>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <a href="{{ route('admin.articles.index') }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Articles</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.videos.*') ? 'active' : '' }}">
                <a href="{{ route('admin.videos.index') }}">
                    <i class="fas fa-video"></i>
                    <span>Video News</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.livetv.*') ? 'active' : '' }}">
                <a href="{{ route('admin.livetv.edit') }}">
                    <i class="fas fa-broadcast-tower"></i>
                    <span>Live TV</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.weather.*') ? 'active' : '' }}">
                <a href="{{ route('admin.weather.edit') }}">
                    <i class="fas fa-cloud-sun"></i>
                    <span>Weather API</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <a href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-list-ul"></i>
                    <span>Categories</span>
                </a>
            </li>
            @if(Auth::check() && Auth::user()->role === 'super_admin')
                <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.edit') }}">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
            @endif
            <li class="border-top border-secondary border-opacity-25 mt-3 pt-3">
                <a href="/">
                    <i class="fas fa-globe"></i>
                    <span>View Website</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content Panel -->
    <main class="main-content">
        <!-- Top bar/header -->
        <header class="admin-header">
            <div>
                <h4 class="fw-bold mb-0">@yield('page_title', 'Admin Dashboard')</h4>
                <p class="text-muted small mb-0">Manage your portal's categories and SEO settings</p>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary border-0 theme-toggle-btn rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" aria-label="Toggle theme">
                    <i class="fas fa-moon"></i>
                </button>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle rounded-pill px-3 border" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> {{ Auth::check() ? Auth::user()->name : 'Admin User' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                        <li>
                            <form action="/logout" method="POST" id="logout-form" class="d-none">
                                @csrf
                            </form>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Flash Message Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>
