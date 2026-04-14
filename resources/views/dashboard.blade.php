@extends('layouts.app')

@section('content')

@php
    $user = auth()->user();
    $tasksQuery = $user->isAdmin() ? \App\Models\Task::query() : \App\Models\Task::where('assigned_to', $user->id);
    
    $total = $tasksQuery->count();
    $completed = (clone $tasksQuery)->where('status', 'completed')->count();
    $progress = (clone $tasksQuery)->where('status', 'progress')->count();
    $pending = (clone $tasksQuery)->where('status', 'pending')->count();
    $overdue = (clone $tasksQuery)->where('deadline', '<', now())
                ->where('status', '!=', 'completed')
                ->count();

    $notifications = \App\Models\Notification::where('user_id', $user->id)
        ->where('is_read', false)
        ->latest()
        ->take(5)
        ->get();

    $recentTasks = (clone $tasksQuery)->latest()->take(5)->get();
@endphp

<div class="space-y-8 animate-in fade-in duration-700">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-white tracking-tight">
                Welcome back, <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-violet-400">{{ explode(' ', $user->name)[0] }}</span>!
            </h1>
            <p class="text-slate-400 mt-1">Here's what's happening with your projects today.</p>
        </div>
        <div class="flex items-center space-x-3">
            @if($user->isAdmin())
                <a href="/tasks/create" class="premium-btn flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Create Task</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass-card p-6 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-500 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Total</span>
            </div>
            <h3 class="text-3xl font-bold text-white">{{ $total }}</h3>
            <p class="text-sm text-slate-400 mt-1">Active tasks</p>
        </div>

        <div class="glass-card p-6 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Done</span>
            </div>
            <h3 class="text-3xl font-bold text-white">{{ $completed }}</h3>
            <p class="text-sm text-slate-400 mt-1">Tasks completed</p>
        </div>

        <div class="glass-card p-6 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-500 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Pending</span>
            </div>
            <h3 class="text-3xl font-bold text-white">{{ $pending }}</h3>
            <p class="text-sm text-slate-400 mt-1">Waiting to start</p>
        </div>

        <div class="glass-card p-6 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-rose-500/10 rounded-2xl flex items-center justify-center text-rose-500 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Overdue</span>
            </div>
            <h3 class="text-3xl font-bold text-white">{{ $overdue }}</h3>
            <p class="text-sm text-slate-400 mt-1">Needs attention</p>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Tasks -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Recent Assignments
                </h2>
                <a href="/tasks" class="text-sm text-indigo-400 hover:text-indigo-300 font-medium transition-colors">View all</a>
            </div>

            <div class="space-y-4">
                @forelse($recentTasks as $task)
                    <div class="glass-card p-5 group flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-2 h-10 rounded-full {{ $task->status === 'completed' ? 'bg-emerald-500' : ($task->status === 'progress' ? 'bg-indigo-500' : 'bg-slate-700') }}"></div>
                            <div>
                                <h4 class="font-semibold text-white group-hover:text-indigo-400 transition-colors">{{ $task->title }}</h4>
                                <div class="flex items-center space-x-3 mt-1">
                                    <span class="text-xs text-slate-500">Due {{ $task->deadline ? $task->deadline->diffForHumans() : 'No date' }}</span>
                                    <span class="status-badge {{ 'status-'.$task->status }}">
                                        {{ $task->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($task->status !== 'completed')
                                <form method="POST" action="/tasks/{{ $task->id }}/status">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <button class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500 hover:text-white transition-all flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                            @endif
                            <a href="/tasks/{{ $task->id }}/edit" class="w-10 h-10 rounded-xl bg-white/5 text-slate-400 hover:bg-white/10 hover:text-white transition-all flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="glass-card p-12 text-center">
                        <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-600">
                             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-white">No tasks assigned</h3>
                        <p class="text-slate-400 mt-1">Enjoy your free time!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Notifications & Activity -->
        <div class="space-y-8">
            <div class="glass-card p-6 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                
                <h3 class="text-lg font-bold text-white mb-6 flex items-center">
                    <span class="relative">
                        🔔
                        @if($notifications->count() > 0)
                            <span class="absolute top-0 right-0 w-2 h-2 bg-rose-500 rounded-full animate-ping"></span>
                        @endif
                    </span>
                    <span class="ml-3">Notifications</span>
                </h3>

                <div class="space-y-4">
                    @forelse($notifications as $note)
                        <div class="flex gap-4 p-3 rounded-xl hover:bg-white/5 transition-colors group">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-violet-500/10 flex items-center justify-center text-violet-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-300">{{ $note->message }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-[10px] text-slate-500 uppercase font-bold">{{ $note->created_at->diffForHumans() }}</span>
                                    <a href="/notifications/{{ $note->id }}/read" class="text-[10px] text-indigo-400 hover:text-white font-bold transition-colors">MARK AS READ</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 text-center py-4 italic">No new notifications</p>
                    @endforelse
                </div>
            </div>

            <!-- Team Members Quick View -->
            <div class="glass-card p-6">
                <h3 class="text-lg font-bold text-white mb-6">Team Activity</h3>
                <div class="space-y-4">
                    @php
                        $members = \App\Models\User::take(5)->get();
                    @endphp
                    @foreach($members as $m)
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-xs font-bold text-white">
                                {{ substr($m->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-white truncate">{{ $m->name }}</p>
                                <p class="text-xs text-slate-500">{{ $m->role }}</p>
                            </div>
                            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection