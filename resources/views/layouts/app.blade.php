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
    </style>
</head>

<body class="antialiased overflow-x-hidden pt-24">
    <!-- Background Accents -->
    <div class="fixed top-0 left-0 w-full h-full -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-500/10 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-violet-500/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s"></div>
    </div>

    @auth
    <!-- Main Header -->
    <header class="fixed top-0 left-0 right-0 z-50 px-4 py-4 pointer-events-none">
        <div class="max-w-7xl mx-auto flex items-center justify-between glass-card px-4 py-3 pointer-events-auto">
            <div class="flex items-center space-x-8">
                <a href="/dashboard" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:rotate-12 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <span class="text-xl font-bold text-white tracking-tight">Task<span class="text-indigo-400">Flow</span></span>
                </a>

                <nav class="hidden lg:flex items-center space-x-1">
                    <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="/tasks" class="nav-link {{ request()->is('tasks*') ? 'active' : '' }}">Tasks</a>
                    <a href="/members" class="nav-link {{ request()->is('members') ? 'active' : '' }}">Members</a>
                    <a href="/teams" class="nav-link {{ request()->is('teams*') ? 'active' : '' }}">Teams</a>
                    <a href="/logs" class="nav-link {{ request()->is('logs') ? 'active' : '' }}">Logs</a>
                </nav>
            </div>

            <div class="flex items-center space-x-3">
                <div class="hidden sm:flex flex-col items-end mr-2 text-right">
                    <span class="text-xs font-bold text-white tracking-tight leading-none">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] text-slate-500 uppercase tracking-widest font-bold mt-1">{{ auth()->user()->role }}</span>
                </div>
                
                <a href="/settings" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-10 h-10 rounded-xl bg-rose-500/10 flex items-center justify-center text-rose-500 hover:bg-rose-500 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>

                <button onclick="document.getElementById('mobileMenu').classList.toggle('hidden')" class="lg:hidden w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <div id="mobileMenu" class="hidden fixed top-20 left-4 right-4 z-50 lg:hidden glass-card p-4 space-y-2 pointer-events-auto animate-in slide-in-from-top duration-300 shadow-2xl">
            <a href="/dashboard" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/5 text-slate-300">Dashboard</a>
            <a href="/tasks" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/5 text-slate-300">Tasks</a>
            <a href="/members" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/5 text-slate-300">Members</a>
            <a href="/teams" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/5 text-slate-300">Teams</a>
            <a href="/logs" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/5 text-slate-300">Logs</a>
        </div>
    </header>
    @endauth

    <main class="max-w-7xl mx-auto px-6 pb-20">
        @yield('content')
    </main>

    <!-- Success/Error Toasts -->
    @if(session('success') || session('error'))
    <div class="fixed bottom-6 right-6 z-[100] animate-in slide-in-from-right duration-500">
        <div class="glass-card px-6 py-4 flex items-center space-x-3 border-l-4 {{ session('success') ? 'border-emerald-500' : 'border-rose-500' }}">
             <div class="text-sm font-medium text-white">{{ session('success') ?? session('error') }}</div>
        </div>
    </div>
    <script>setTimeout(() => { document.querySelector('.fixed.bottom-6').style.display = 'none'; }, 4000);</script>
    @endif
</body>
</html>