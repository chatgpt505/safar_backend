<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Safar Backend')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="h-full bg-gray-100 dark:bg-dark-900 transition-colors duration-200">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-dark-800 shadow-lg border-b border-gray-200 dark:border-dark-700">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Sidebar Toggle -->
                    @auth
                    <button id="sidebarToggle" class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-dark-700 mr-3">
                        <i class="fas fa-bars"></i>
                    </button>
                    @endauth
                    
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800 dark:text-white">
                            <i class="fas fa-plane text-blue-600 mr-2"></i>
                            Safar Backend
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button id="darkModeToggle" class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-dark-700">
                        <i class="fas fa-moon dark:hidden"></i>
                        <i class="fas fa-sun hidden dark:block"></i>
                    </button>
                    
                    @auth
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                        <span class="px-2 py-1 text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar and Main Content -->
    <div class="flex h-[calc(100vh-4rem)]">
        @auth
        <!-- Sidebar -->
        <div id="sidebar" class="w-64 bg-white dark:bg-dark-800 shadow-lg border-r border-gray-200 dark:border-dark-700 transition-all duration-300 transform translate-x-0">
            <div class="p-4">
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-dark-700 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg transition-colors">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('dashboard.admin') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-dark-700 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg transition-colors">
                        <i class="fas fa-crown mr-3"></i>
                        <span>Admin Panel</span>
                    </a>
                    <a href="{{ route('dashboard.users') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-dark-700 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg transition-colors">
                        <i class="fas fa-users mr-3"></i>
                        <span>User Management</span>
                    </a>
                    <a href="{{ route('dashboard.roles.index') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-dark-700 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg transition-colors">
                        <i class="fas fa-user-tag mr-3"></i>
                        <span>Role Management</span>
                    </a>
                    @endif
                    
                    <a href="{{ route('dashboard.profile') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-dark-700 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg transition-colors">
                        <i class="fas fa-user mr-3"></i>
                        <span>Profile</span>
                    </a>
                    
                    <a href="{{ route('dashboard.settings') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-dark-700 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg transition-colors">
                        <i class="fas fa-cog mr-3"></i>
                        <span>Settings</span>
                    </a>
                    
                    <a href="{{ url('api/documentation') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-dark-700 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg transition-colors" target="_blank">
                        <i class="fas fa-book mr-3"></i>
                        <span>API Docs</span>
                    </a>
                    
                    <!-- Sample CRUD Links -->
                    <div class="border-t border-gray-200 dark:border-dark-700 pt-4 mt-4">
                        <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 px-4">Sample CRUD</h3>
                        <a href="{{ route('dashboard.products.index') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-dark-700 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg transition-colors">
                            <i class="fas fa-box mr-3"></i>
                            <span>Products</span>
                        </a>
                        <a href="{{ route('dashboard.categories.index') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-dark-700 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg transition-colors">
                            <i class="fas fa-tags mr-3"></i>
                            <span>Categories</span>
                        </a>
                        <a href="{{ route('dashboard.orders.index') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-dark-700 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg transition-colors">
                            <i class="fas fa-shopping-cart mr-3"></i>
                            <span>Orders</span>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
        @endauth

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
    
    <script>
        // Dark mode functionality
        const darkModeToggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;
        
        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        }
        
        darkModeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('darkMode', html.classList.contains('dark'));
        });
        
        // Sidebar toggle functionality
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
            
            // Close sidebar on mobile when clicking outside
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 768 && 
                    !sidebar.contains(e.target) && 
                    !sidebarToggle.contains(e.target)) {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        }
    </script>
</body>
</html>
