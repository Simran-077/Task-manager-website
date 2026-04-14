<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TaskPremium') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Outfit', sans-serif; }
        
        .auth-bg {
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(139, 92, 246, 0.15) 0px, transparent 50%);
        }
    </style>
</head>
<body class="antialiased bg-[#0f172a] text-slate-200 min-h-screen auth-bg">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Brand/Logo Area -->
        <div class="mb-8 animate-in fade-in slide-in-from-top duration-700">
            <a href="/" class="flex flex-col items-center group">
                <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-indigo-500/40 shadow-2xl group-hover:rotate-12 transition-transform duration-300">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <h1 class="mt-4 text-3xl font-bold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400">TaskFlow</h1>
            </a>
        </div>

        <!-- Auth Card -->
        <div class="w-full sm:max-w-md px-8 py-10 glass-card animate-in fade-in zoom-in duration-500">
            <div class="mb-8">
                @if(request()->is('login'))
                    <h2 class="text-2xl font-bold text-white">Welcome Back</h2>
                    <p class="text-slate-400 text-sm mt-1">Please enter your details to sign in.</p>
                @elseif(request()->is('register'))
                    <h2 class="text-2xl font-bold text-white">Join TaskFlow</h2>
                    <p class="text-slate-400 text-sm mt-1">Create an account to start managing tasks.</p>
                @else
                    <h2 class="text-2xl font-bold text-white">Hello!</h2>
                @endif
            </div>

            <div class="auth-forms">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer Links -->
        <div class="mt-8 text-center text-sm text-slate-500">
            &copy; {{ date('Y') }} TaskFlow Premium. Experience the next level of management.
        </div>
    </div>
</body>
</html>
