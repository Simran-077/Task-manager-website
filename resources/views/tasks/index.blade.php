@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white">Pipeline Overview</h1>
            <p class="text-slate-400">Manage and track all assignments across your organization.</p>
        </div>
        @if(auth()->user()->isAdmin())
            <a href="/tasks/create" class="premium-btn flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>New Assignment</span>
            </a>
        @endif
    </div>

    <!-- Filters -->
    <form method="GET" action="/tasks" class="glass-card p-4 flex flex-col md:flex-row gap-4 items-end">
        <div class="flex-1 w-full">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Search Tasks</label>
            <div class="relative">
                <input type="text" name="search" placeholder="Filter by title..." value="{{ request('search') }}" class="premium-input w-full pl-10">
                <svg class="w-4 h-4 text-slate-500 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
        
        <div class="w-full md:w-48">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Status</label>
            <select name="status" class="premium-input w-full">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="progress" {{ request('status') == 'progress' ? 'selected' : '' }}>Progress</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="w-full md:w-48">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Priority</label>
            <select name="priority" class="premium-input w-full">
                <option value="">All Priority</option>
                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
            </select>
        </div>

        <button class="premium-btn !bg-slate-800 hover:!bg-slate-700 w-full md:w-auto h-[46px]">Filter</button>
    </form>

    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-white/5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                        <th class="px-6 py-4">Assignment</th>
                        <th class="px-6 py-4">Assigned To</th>
                        <th class="px-6 py-4">Timeline</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($tasks as $task)
                        <tr class="group hover:bg-white/5 transition-all duration-300">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-1.5 h-10 rounded-full {{ $task->priority === 'high' ? 'bg-rose-500' : ($task->priority === 'medium' ? 'bg-amber-500' : 'bg-emerald-500') }}"></div>
                                    <div>
                                        <div class="font-bold text-white group-hover:text-indigo-400 transition-colors">{{ $task->title }}</div>
                                        <div class="text-[10px] text-slate-500 uppercase tracking-tight">Global</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center font-bold text-xs text-indigo-400">
                                        {{ substr($task->assignedUser->name ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-slate-300">{{ $task->assignedUser->name ?? 'Unassigned' }}</div>
                                        <div class="text-[10px] text-slate-500">{{ $task->assignedUser->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-300">{{ $task->deadline ? $task->deadline->format('M d, Y') : 'No date' }}</div>
                                <div class="text-[10px] font-bold {{ $task->deadline && $task->deadline->isPast() && $task->status !== 'completed' ? 'text-rose-500' : 'text-slate-500' }} uppercase tracking-tight">
                                    {{ $task->deadline ? $task->deadline->diffForHumans() : '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="status-badge status-{{ $task->status }}">
                                    {{ $task->status }}
                                </span>
                                @if($task->deadline && $task->deadline->isPast() && $task->status !== 'completed')
                                    <span class="status-badge status-overdue ml-2">OVERDUE</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end space-x-2">
                                    @if($task->status !== 'completed')
                                        <form method="POST" action="/tasks/{{ $task->id }}/status">
                                            @csrf
                                            <input type="hidden" name="status" value="completed">
                                            <button title="Mark Done" class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500 hover:text-white transition-all flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="/tasks/{{ $task->id }}/edit" title="Edit Task" class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 hover:bg-white/10 hover:text-white transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>

                                    <form method="POST" action="/tasks/{{ $task->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Delete" class="w-8 h-8 rounded-lg bg-rose-500/10 text-rose-500 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-800 rounded-3xl flex items-center justify-center text-slate-600 mb-4">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-white">No assignments found</h3>
                                    <p class="text-slate-400 mt-2">Try adjusting your filters or create a new task.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection