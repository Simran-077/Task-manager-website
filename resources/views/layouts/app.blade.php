<!DOCTYPE html>
<html lang="en" class="{{ auth()->check() ? auth()->user()->theme : 'dark' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TaskPremium') }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Outfit', sans-serif; }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>

<body class="antialiased overflow-x-hidden">
    <!-- Background Accents -->
    <div class="fixed top-0 left-0 w-full h-full -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-500/10 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-violet-500/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s"></div>
    </div>

    @auth
    <!-- Premium Navigation -->
    <nav class="sticky top-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto glass-card !rounded-2xl px-6 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-8">
                <a href="/dashboard" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-indigo-500/40 shadow-lg group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400">TaskFlow</span>
                </a>

                <div class="hidden md:flex items-center space-x-1">
                    <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="/tasks" class="nav-link {{ request()->is('tasks*') ? 'active' : '' }}">Tasks</a>
                    <a href="/members" class="nav-link {{ request()->is('members') ? 'active' : '' }}">Members</a>
                    @if(auth()->user()->isAdmin())
                        <a href="/teams" class="nav-link {{ request()->is('teams*') ? 'active' : '' }}">Teams</a>
                        <a href="/logs" class="nav-link {{ request()->is('logs') ? 'active' : '' }}">Logs</a>
                    @endif
                </div>
            </div>

            <div class="flex items-center space-x-6">
                <div class="hidden sm:flex flex-col items-end mr-2">
                    <span class="text-sm font-semibold text-white">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] text-slate-400 uppercase tracking-widest">{{ auth()->user()->role }}</span>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="/settings" class="w-10 h-10 glass-card !rounded-full flex items-center justify-center hover:text-indigo-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-10 h-10 glass-card !rounded-full flex items-center justify-center text-rose-500 hover:bg-rose-500/10 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>

                <!-- Mobile Menu Button -->
                <button onclick="toggleMenu()" class="md:hidden w-10 h-10 glass-card !rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden mt-4 glass-card p-4 space-y-2 md:hidden">
            <a href="/dashboard" class="block nav-link">Dashboard</a>
            <a href="/tasks" class="block nav-link">Tasks</a>
            <a href="/members" class="block nav-link">Members</a>
            @if(auth()->user()->isAdmin())
                <a href="/teams" class="block nav-link">Teams</a>
                <a href="/logs" class="block nav-link">Logs</a>
            @endif
            <a href="/settings" class="block nav-link">Settings</a>
        </div>
    </nav>
    @endauth

    <main class="max-w-7xl mx-auto px-6 pb-20 pt-4">
        @yield('content')
    </main>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>