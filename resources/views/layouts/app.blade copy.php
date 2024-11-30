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
            --primary-color: #4a5568;
            --secondary-color: #718096;
            --background-light: #f7fafc;
            --text-dark: #2d3748;
            --menu-width: 280px;
            --menu-collapsed-width: 80px;
            --header-height: 70px;
            --transition-speed: 0.3s;
        }

        body {
            background-color: var(--background-light);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 24px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            z-index: 1100;
            /* Aumentei o z-index para garantir que fique sempre por cima */
        }

        .vertical-menu {
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: var(--menu-width);
            background-color: white;
            box-shadow: -2px 0 20px rgba(0, 0, 0, 0.05);
            transition: width var(--transition-speed) ease;
            z-index: 1000;
            padding-top: var(--header-height);
        }

        .vertical-menu.collapsed {
            width: var(--menu-collapsed-width);
        }

        .toggle-menu {
            position: absolute;
            bottom: 20px;
            right: 20px;
            /* Mudei para a direita */
            background: #718096;
            /* Cor cinza */
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px;
            cursor: pointer;
            transition: all var(--transition-speed);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }

        .toggle-menu:hover {
            background: #4a5568;
        }

        .vertical-menu.collapsed .toggle-menu {
            transform: rotate(180deg);
        }

        .main-content {
            margin-right: var(--menu-width);
            margin-top: var(--header-height);
            padding: 24px;
            transition: margin-right var(--transition-speed) ease;
        }

        .main-content.expanded {
            margin-right: var(--menu-collapsed-width);
        }

        @media (max-width: 768px) {
            .main-content {
                margin-right: 0;
            }
        }

        /* Resto dos estilos similares ao anterior, vou omitir por brevidade */
        .vertical-menu-item {
            display: flex;
            align-items: center;
            padding: 16px 24px;
            text-decoration: none;
            color: var(--text-dark);
            transition: all var(--transition-speed);
            border-right: 3px solid transparent;
            overflow: hidden;
            white-space: nowrap;
        }

        .vertical-menu-item:hover {
            background-color: rgba(96, 125, 139, 0.1);
            color: var(--primary-color);
            border-right-color: var(--primary-color);
        }

        .vertical-menu-item i {
            min-width: 24px;
            font-size: 1.25rem;
            text-align: center;
            margin-right: 16px;
            transition: margin var(--transition-speed);
        }

        .vertical-menu.collapsed .vertical-menu-item {
            padding: 16px 28px;
        }

        .vertical-menu.collapsed .vertical-menu-item i {
            margin-right: 0;
        }

        .vertical-menu.collapsed .vertical-menu-item span {
            opacity: 0;
            visibility: hidden;
        }

        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
        }

        .user-menu {
            position: absolute;
            top: calc(100% + 5px);
            right: 0;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 10px;
            display: none;
            z-index: 1200;
            min-width: 150px;
        }

        .user-menu .user-menu-item {
            display: flex;
            align-items: center;
            padding: 10px;
            text-decoration: none;
            color: var(--text-dark);
            border-radius: 6px;
            transition: background-color 0.2s;
        }

        .user-menu .user-menu-item:hover {
            background-color: rgba(96, 125, 139, 0.1);
            color: var(--primary-color);
        }

        .user-menu.active {
            display: block;
        }


        /* Cores mais neutras e profissionais */
        .vertical-menu-item.active,
        .vertical-menu-item:hover {
            background-color: rgba(96, 125, 139, 0.1);
            color: var(--primary-color);
            border-right-color: var(--primary-color);
        }
    </style>
</head>

<body>
    <!-- Top Header - mantido igual -->
    <header class="top-header">
        <div class="search-container">
            <input type="text" placeholder="Search..." class="form-control">
        </div>

        <div class="user-profile" onclick="toggleDropdown(event)">
            <img src="/default-avatar.png" alt="User">
            <div class="user-info">
                <span class="user-name">{{ Auth::user()->name ?? 'User' }}</span>
                <span class="user-role">Administrator</span>
            </div>
            <i class="bi bi-chevron-down ms-2"></i>
        </div>
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

        <a href="/candidates" class="vertical-menu-item">
            <i class="bi bi-graph-up"></i>
            <span>Reports</span>
        </a>
        <a href="/settings" class="vertical-menu-item">
            <i class="bi bi-gear"></i>
            <span>Settings</span>
        </a>
        <hr class="my-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="user-menu-item w-100 text-start border-0 bg-transparent">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </button>
        </form>

        <!-- Toggle Menu Button - movido para o final e com cor cinza -->
        <button class="toggle-menu" onclick="toggleSidebar()">
            <i class="bi bi-chevron-right"></i>
        </button>
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

    <script>
        function toggleDropdown(event) {
            event.stopPropagation(); // Impede que o clique se propague para o document
            const userMenu = document.querySelector('.user-menu');

            if (userMenu) {
                const isVisible = userMenu.classList.contains('active');
                document.querySelectorAll('.user-menu').forEach(menu => menu.classList.remove('active')); // Fecha outros menus
                if (!isVisible) {
                    userMenu.classList.add('active');
                }
            }
        }

        // Fecha o dropdown ao clicar fora
        document.addEventListener('click', function() {
            document.querySelectorAll('.user-menu').forEach(menu => menu.classList.remove('active'));
        });


        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.querySelector('.vertical-menu');
            const mainContent = document.querySelector('.main-content');
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        });
    </script>
    @yield('scripts')

</body>

</html>


<!-- Este script ajuda a garantir o fechamento do dropdown quando clicar fora -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(event) {
            const userProfile = document.querySelector('.user-profile');
            const userMenu = document.querySelector('.user-menu');

            if (userProfile && userMenu) {
                if (!userProfile.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenu.style.opacity = '0';
                    userMenu.style.visibility = 'hidden';
                }
            }
        });
    });
</script>