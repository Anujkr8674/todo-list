<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Todo List - Dashboard')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="app-body">

    <!-- Mobile Top Bar (Visible only on mobile/tablet screens < 992px) -->
    <header class="mobile-top-bar d-lg-none sticky-top bg-white border-bottom px-3 py-2 d-flex align-items-center justify-content-between shadow-sm">
        <!-- Left: Hamburger Menu Button -->
        <button class="btn btn-link text-dark p-1 border-0 drawer-toggle-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#appSidebarDrawer" aria-controls="appSidebarDrawer" aria-label="Open navigation drawer">
            <i class="bi bi-list fs-2 text-primary"></i>
        </button>

        <!-- Center: Brand Logo / Name -->
        <a href="{{ route('dashboard') }}" class="text-decoration-none d-inline-flex align-items-center gap-2">
            <i class="bi bi-check2-square fs-4 text-primary"></i>
            <span class="fw-bold fs-5" style="color: var(--primary-color);">Todo List</span>
        </a>

        <!-- Right: User Avatar Circle (First letter of user name) -->
        <div class="user-avatar-circle user-avatar-sm" title="{{ Auth::user()->name }}">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
    </header>

    <!-- Sidebar / App Drawer (Offcanvas on mobile, fixed left sidebar on desktop) -->
    <aside class="offcanvas-lg offcanvas-start app-sidebar bg-white border-end" tabindex="-1" id="appSidebarDrawer" aria-labelledby="appSidebarDrawerLabel">
        <!-- Sidebar Header -->
        <div class="sidebar-header p-3 p-lg-4 border-bottom d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="text-decoration-none d-inline-flex align-items-center gap-2">
                <div class="brand-icon-box rounded-3 bg-primary-subtle d-flex align-items-center justify-content-center text-primary">
                    <i class="bi bi-check2-square fs-4"></i>
                </div>
                <span class="fw-bold fs-5" style="color: var(--primary-color);">Todo List</span>
            </a>
            <!-- Close button for mobile drawer -->
            <button type="button" class="btn-close d-lg-none text-reset" data-bs-dismiss="offcanvas" data-bs-target="#appSidebarDrawer" aria-label="Close drawer"></button>
        </div>

        <!-- Sidebar Navigation -->
        <div class="sidebar-body p-3 d-flex flex-column flex-grow-1 justify-content-between">
            <div>
                <small class="text-muted fw-semibold text-uppercase px-3 mb-2 d-block" style="font-size: 0.72rem; letter-spacing: 0.08em;">Navigation</small>
                <nav class="nav nav-pills flex-column gap-1">
                    <a class="nav-link sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-2 fs-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a class="nav-link sidebar-link {{ request()->routeIs('todos.index') ? 'active' : '' }}" href="{{ route('todos.index') }}">
                        <i class="bi bi-list-task me-2 fs-5"></i>
                        <span>All Tasks</span>
                    </a>
                    <a class="nav-link sidebar-link {{ request()->routeIs('todos.create') ? 'active' : '' }}" href="{{ route('todos.create') }}">
                        <i class="bi bi-plus-circle me-2 fs-5"></i>
                        <span>Add New Task</span>
                    </a>
                </nav>
            </div>

            <!-- Sidebar Footer: User Profile & Logout -->
            <div class="sidebar-footer pt-3 mt-4 border-top">
                <div class="d-flex align-items-center gap-3 p-2 rounded-3 bg-light mb-3">
                    <div class="user-avatar-circle flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="fw-semibold text-dark text-truncate small" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</div>
                        <div class="text-muted text-truncate" style="font-size: 0.75rem;" title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2 fw-medium d-inline-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="main-wrapper">
        <main class="py-4 py-md-5">
            <div class="container-fluid px-3 px-md-4 px-xl-5">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <!-- <footer class="py-3 border-top bg-white mt-auto">
            <div class="container-fluid px-3 px-md-4 px-xl-5 text-center text-muted small">
                &copy; {{ date('Y') }} Todo List. Simple personal task manager.
            </div>
        </footer> -->
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
