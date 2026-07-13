<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rivaaz Admin - Enterprise News SaaS')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite Assets -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <style>
        /* Compact specific styles for admin console layout elements */
        :root {
            --admin-sidebar-width: 260px;
            --admin-sidebar-collapsed-width: 70px;
            --admin-sidebar-bg: #111827;
            --admin-sidebar-color: #9ca3af;
            --admin-sidebar-hover-bg: #1f2937;
            --admin-sidebar-active-bg: var(--primary-color);
        }
        
        body.admin-body {
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
        }

        .admin-sidebar {
            width: var(--admin-sidebar-width);
            background-color: var(--admin-sidebar-bg);
            color: var(--admin-sidebar-color);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255,255,255,0.05);
        }

        .admin-sidebar.collapsed {
            width: var(--admin-sidebar-collapsed-width);
        }

        .admin-sidebar .sidebar-brand {
            padding: 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            overflow: hidden;
            white-space: nowrap;
        }

        .admin-sidebar .sidebar-brand h5 {
            margin: 0;
            color: #fff;
            font-size: 1.15rem;
            font-weight: 700;
        }

        .admin-sidebar .sidebar-menu {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1rem 0;
        }

        .admin-sidebar .menu-section {
            padding: 0.5rem 1.5rem;
            font-size: 0.65rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #4b5563;
        }
        
        .admin-sidebar.collapsed .menu-section {
            display: none;
        }

        .admin-sidebar .nav-link-admin {
            display: flex;
            align-items: center;
            padding: 0.65rem 1.5rem;
            color: #9ca3af;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.85rem;
            white-space: nowrap;
            border-left: 3px solid transparent;
        }

        .admin-sidebar .nav-link-admin i {
            width: 20px;
            margin-right: 10px;
            font-size: 1.1rem;
            text-align: center;
        }

        .admin-sidebar.collapsed .nav-link-admin span {
            display: none;
        }

        .admin-sidebar .nav-link-admin:hover {
            background-color: var(--admin-sidebar-hover-bg);
            color: #fff;
        }

        .admin-sidebar .nav-link-admin.active {
            background-color: var(--admin-sidebar-hover-bg);
            color: #fff;
            border-left-color: var(--primary-color);
        }

        .admin-main-wrapper {
            margin-left: var(--admin-sidebar-width);
            width: calc(100% - var(--admin-sidebar-width));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .admin-main-wrapper.full-width {
            margin-left: var(--admin-sidebar-collapsed-width);
            width: calc(100% - var(--admin-sidebar-collapsed-width));
        }

        .admin-top-nav {
            height: 60px;
            background-color: var(--bs-card-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .admin-content {
            flex-grow: 1;
            padding: 1.5rem;
            background-color: var(--bg-color);
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.mobile-open {
                transform: translateX(0);
                width: var(--admin-sidebar-width) !important;
            }
            .admin-sidebar.mobile-open .nav-link-admin span {
                display: block !important;
            }
            .admin-main-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }
    </style>
</head>
<body class="admin-body">

    <!-- 1. Sidebar Navigation -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <h5 class="m-0"><i class="fa-solid fa-layer-group text-primary me-2"></i><span>Rivaaz Admin</span></h5>
            <button class="btn btn-link text-white p-0 d-none d-lg-block" id="sidebarToggleBtn" aria-label="Toggle Sidebar">
                <i class="fa-solid fa-indent"></i>
            </button>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-section">Core Hub</div>
            <a href="/admin" class="nav-link-admin {{ Request::is('admin') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i> <span>Dashboard</span>
            </a>
            
            <div class="menu-section">Content Area</div>
            <a href="/admin/news" class="nav-link-admin {{ Request::is('admin/news') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i> <span>Articles List</span>
            </a>
            <a href="/admin/news/create" class="nav-link-admin {{ Request::is('admin/news/create') ? 'active' : '' }}">
                <i class="fa-regular fa-file-lines"></i> <span>Write Article</span>
            </a>
            <a href="/admin/categories" class="nav-link-admin {{ Request::is('admin/categories') ? 'active' : '' }}">
                <i class="fa-solid fa-folder-open"></i> <span>Categories & Subs</span>
            </a>
            <a href="/admin/live-blog" class="nav-link-admin {{ Request::is('admin/live-blog') ? 'active' : '' }}">
                <i class="fa-solid fa-broadcast-tower"></i> <span>Live Blog & Breaking</span>
            </a>
            <a href="/admin/media" class="nav-link-admin {{ Request::is('admin/media') ? 'active' : '' }}">
                <i class="fa-regular fa-images"></i> <span>Media Library</span>
            </a>
            <a href="/admin/web-stories" class="nav-link-admin {{ Request::is('admin/web-stories') ? 'active' : '' }}">
                <i class="fa-solid fa-mobile-screen"></i> <span>Web Stories</span>
            </a>
            
            <div class="menu-section">SaaS Placements</div>
            <a href="/admin/ads" class="nav-link-admin {{ Request::is('admin/ads') ? 'active' : '' }}">
                <i class="fa-solid fa-rectangle-ad"></i> <span>Advertisements</span>
            </a>
            <a href="/admin/seo" class="nav-link-admin {{ Request::is('admin/seo') ? 'active' : '' }}">
                <i class="fa-solid fa-magnifying-glass-chart"></i> <span>SEO & Sitemaps</span>
            </a>
            <a href="/admin/code-injections" class="nav-link-admin {{ Request::is('admin/code-injections') ? 'active' : '' }}">
                <i class="fa-solid fa-code"></i> <span>Code Injections</span>
            </a>
            
            <div class="menu-section">SaaS Control</div>
            <a href="/admin/users" class="nav-link-admin {{ Request::is('admin/users') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> <span>Roles & Users</span>
            </a>
            <a href="/admin/settings" class="nav-link-admin {{ Request::is('admin/settings') ? 'active' : '' }}">
                <i class="fa-solid fa-sliders"></i> <span>System Settings</span>
            </a>
            <a href="/admin/support" class="nav-link-admin {{ Request::is('admin/support') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-info"></i> <span>Support & Logs</span>
            </a>
            
            <div class="menu-section">Portal</div>
            <a href="/" class="nav-link-admin">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> <span>View Portal UI</span>
            </a>
        </div>

        <div class="p-3 border-top border-secondary border-opacity-10 text-center text-muted small">
            <span class="d-block">SaaS Enterprise v1.2</span>
        </div>
    </aside>

    <!-- 2. Main Wrapper -->
    <main class="admin-main-wrapper" id="adminMainWrapper">
        
        <!-- Top Navigation -->
        <header class="admin-top-nav">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none" id="mobileSidebarToggle" aria-label="Toggle mobile menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                
                <!-- Tenant Switcher Dropdown (Multi-Tenant News SaaS) -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 border-secondary-subtle" type="button" id="tenantSelector" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-globe text-primary"></i>
                        <span>Rivaaz Chronicle</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-start shadow-sm" aria-labelledby="tenantSelector">
                        <li><h6 class="dropdown-header">Active Tenant Nodes</h6></li>
                        <li><a class="dropdown-item active" href="#" onclick="switchTenant('Rivaaz Chronicle')"><i class="fa-solid fa-circle-check text-primary me-2"></i> Rivaaz Chronicle (Main)</a></li>
                        <li><a class="dropdown-item" href="#" onclick="switchTenant('Sarkar News')"><i class="fa-solid fa-circle me-2 text-muted small"></i> Sarkar News</a></li>
                        <li><a class="dropdown-item" href="#" onclick="switchTenant('Metro Times')"><i class="fa-solid fa-circle me-2 text-muted small"></i> Metro Times</a></li>
                    </ul>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                
                <!-- User Role switch panel (Role-Based Demo) -->
                <div class="dropdown d-none d-md-block">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle border-secondary-subtle" type="button" id="roleSelector" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user-shield text-danger me-1"></i> Role: <strong id="activeRoleName">Super Admin</strong>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="roleSelector">
                        <li><h6 class="dropdown-header">Simulate Dashboard Role</h6></li>
                        <li><a class="dropdown-item" href="#" onclick="switchRole('Super Admin')">Super Admin</a></li>
                        <li><a class="dropdown-item" href="#" onclick="switchRole('Chief Editor')">Chief Editor</a></li>
                        <li><a class="dropdown-item" href="#" onclick="switchRole('Reporter')">Reporter</a></li>
                        <li><a class="dropdown-item" href="#" onclick="switchRole('SEO Manager')">SEO Manager</a></li>
                        <li><a class="dropdown-item" href="#" onclick="switchRole('Advertiser')">Advertiser</a></li>
                    </ul>
                </div>

                <!-- Theme switch trigger -->
                <button class="btn btn-sm btn-outline-secondary border-0 theme-toggle-btn" aria-label="Toggle theme" id="themeToggleBtn">
                    <i class="fa-solid fa-moon fs-5"></i>
                </button>

                <!-- Profile avatar -->
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle text-reset" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" alt="Admin Avatar" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="profileDropdown">
                        <li><h6 class="dropdown-header">Super Admin Node</h6></li>
                        <li><a class="dropdown-item" href="/admin/settings"><i class="fa-solid fa-gear me-2 text-muted"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="alert('Session logged out (Simulated)');"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
                    </ul>
                </div>

            </div>
        </header>

        <!-- Content Area -->
        <section class="admin-content">
            @yield('admin-content')
        </section>

    </main>

    <!-- Interactive alert notification container -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
        <div id="adminToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    Welcome to the News SaaS Control Panel!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap Script setup -->
    <script>
        // Inline state switch helpers for Tenant and Role switch simulation
        function switchTenant(tenantName) {
            document.querySelector('#tenantSelector span').innerText = tenantName;
            showNotification(`Switched to active tenant node: ${tenantName}`);
        }
        function switchRole(roleName) {
            document.getElementById('activeRoleName').innerText = roleName;
            showNotification(`Dashboard permissions adjusted for: ${roleName}`);
        }
        function showNotification(message) {
            document.getElementById('toastMessage').innerText = message;
            const toastEl = document.getElementById('adminToast');
            // If bootstrap toast is available
            if (window.bootstrap) {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            } else {
                alert(message);
            }
        }
    </script>
</body>
</html>
