@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="flex items-center space-x-4 mb-8">
        <div class="w-12 h-12 glass-card !rounded-2xl flex items-center justify-center text-indigo-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-white">Create New Assignment</h1>
            <p class="text-slate-400">Deploy a new mission for your team members.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/tasks" class="space-y-6">
        @csrf
        
        <div class="glass-card p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-400 mb-1">Assignment Title</label>
                    <input type="text" name="title" required class="premium-input w-full" placeholder="e.g. Monthly Performance Review">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-400 mb-1">Detailed Description</label>
                    <textarea name="description" rows="4" class="premium-input w-full" placeholder="What needs to be done?"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Priority Level</label>
                    <select name="priority" class="premium-input w-full">
                        <option value="low">Low Priority</option>
                        <option value="medium" selected>Medium Priority</option>
                        <option value="high">High Priority</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Target Deadline</label>
                    <input type="datetime-local" name="deadline" required class="premium-input w-full">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Select Team</label>
                    <select name="team_id" class="premium-input w-full" required>
                        <option value="">Choose a team...</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Assign To Specialist</label>
                    <select name="assigned_to" class="premium-input w-full" required>
                        <option value="">Select member...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end pt-6 border-t border-white/5 space-x-4">
                <a href="/tasks" class="text-slate-400 hover:text-white transition-colors font-medium">Cancel</a>
                <button type="submit" class="premium-btn">
                    Launch Assignment
                </button>
            </div>
        </div>
    </form>
</div>
@endsection