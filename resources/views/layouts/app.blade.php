<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4">

<div class="flex justify-between items-center">

    <h1 class="text-xl font-bold">Task Manager</h1>

    <!-- Desktop Menu -->
    <div class="hidden md:flex space-x-4 items-center">
        <a href="/dashboard">Dashboard</a>
        <a href="/tasks">Tasks</a>
        @if(auth()->user()->isAdmin())
            <a href="/teams/create">Teams</a>
            <a href="/logs">Logs</a>
        @endif
        <a href="/settings">Settings</a>

        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-red-500 font-bold ml-4">
                Logout
            </button>
        </form>
    </div>

    <!-- Mobile Button -->
    <button onclick="toggleMenu()" class="md:hidden text-2xl">
        ☰
    </button>

</div>

<!-- Mobile Menu -->
<div id="mobileMenu" class="hidden mt-4 flex flex-col space-y-2 md:hidden">
    <a href="/dashboard" class="py-2">Dashboard</a>
    <a href="/tasks" class="py-2">Tasks</a>
    @if(auth()->user()->isAdmin())
        <a href="/teams/create" class="py-2">Teams</a>
        <a href="/logs" class="py-2">Logs</a>
    @endif
    <a href="/settings" class="py-2">Settings</a>
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-red-500 font-bold py-2">
            Logout
        </button>
    </form>
</div>


</nav>

<script>
function toggleMenu() {
    document.getElementById('mobileMenu').classList.toggle('hidden');
}
</script>

<div class="max-w-6xl mx-auto">
    @yield('content')
</div>

</body>
</html>