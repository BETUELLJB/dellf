<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #6b46c1;
            --secondary-color: #4fd1c5;
            --background-light: #f8fafc;
            --text-dark: #2d3748;
            --menu-width: 280px;
            --header-height: 70px;
            --transition-speed: 0.3s;
        }

        body {
            background-color: var(--background-light);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
        }

        .vertical-menu {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--menu-width);
            background-color: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            transition: transform var(--transition-speed) ease;
            z-index: 1000;
            padding-top: var(--header-height);
        }

        @media (max-width: 768px) {
            .vertical-menu {
                transform: translateX(-100%);
            }
            
            .vertical-menu.active {
                transform: translateX(0);
            }
        }

        .vertical-menu-item {
            display: flex;
            align-items: center;
            padding: 16px 24px;
            text-decoration: none;
            color: var(--text-dark);
            transition: all var(--transition-speed);
            border-left: 3px solid transparent;
        }

        .vertical-menu-item:hover {
            background-color: rgba(107, 70, 193, 0.08);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }

        .vertical-menu-item i {
            margin-right: 16px;
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }

        .vertical-menu-item span {
            font-weight: 500;
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 24px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            z-index: 999;
        }

        .main-content {
            margin-left: var(--menu-width);
            margin-top: var(--header-height);
            padding: 24px;
            transition: margin-left var(--transition-speed) ease;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }

        .search-container {
            flex: 1;
            max-width: 400px;
            margin-right: 24px;
        }

        .search-container .form-control {
            background-color: var(--background-light);
            border: none;
            padding: 12px 16px;
            border-radius: 8px;
        }

        .user-profile {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color var(--transition-speed);
        }

        .user-profile:hover {
            background-color: var(--background-light);
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: #666;
        }

        .user-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all var(--transition-speed);
        }

        .user-profile:hover .user-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-menu-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: var(--text-dark);
            text-decoration: none;
            transition: background-color var(--transition-speed);
        }

        .user-menu-item:hover {
            background-color: var(--background-light);
        }

        .user-menu-item i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-dark);
            padding: 8px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Top Header -->
    <header class="top-header">
        <button class="menu-toggle" onclick="toggleMenu()">
            <i class="bi bi-list"></i>
        </button>
        
        <div class="search-container">
            <input type="text" placeholder="Search..." class="form-control">
        </div>
        
        <div class="user-profile">
            <img src="/default-avatar.png" alt="User Avatar">
            <div class="user-info">
                <span class="user-name">{{ Auth::user()->name ?? 'User' }}</span>
                <span class="user-role">Administrator</span>
            </div>
            <i class="bi bi-chevron-down ms-2"></i>
            
            <div class="user-menu">
                <a href="/profile" class="user-menu-item">
                    <i class="bi bi-person"></i>
                    Profile
                </a>
                <a href="/settings" class="user-menu-item">
                    <i class="bi bi-gear"></i>
                    Settings
                </a>
                <hr class="my-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="user-menu-item w-100 text-start border-0 bg-transparent">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Vertical Menu -->
    <nav class="vertical-menu">
        <a href="/dashboard" class="vertical-menu-item">
            <i class="bi bi-house-door"></i>
            <span>Dashboard</span>
        </a>
        <a href="/users" class="vertical-menu-item">
            <i class="bi bi-people"></i>
            <span>Users</span>
        </a>
        <a href="/products" class="vertical-menu-item">
            <i class="bi bi-box"></i>
            <span>Products</span>
        </a>
        <a href="/logs" class="vertical-menu-item">
            <i class="bi bi-cart"></i>
            <span>Logs</span>
        </a>
        <a href="/movies" class="vertical-menu-item">
            <i class="bi bi-film"></i>
            <span>Movies</span>
        </a>
        <a href="/reports" class="vertical-menu-item">
            <i class="bi bi-graph-up"></i>
            <span>Reports</span>
        </a>
        <a href="/settings" class="vertical-menu-item">
            <i class="bi bi-gear"></i>
            <span>Settings</span>
        </a>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @if (isset($header))
        <header class="bg-white shadow-sm rounded-lg mb-4 p-4">
            {{ $header }}
        </header>
        @endif

        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleMenu() {
            document.querySelector('.vertical-menu').classList.toggle('active');
        }
    </script>
</body>
</html>