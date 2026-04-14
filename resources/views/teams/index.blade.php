@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white">Teams & Squads</h1>
            <p class="text-slate-400">Manage your team structures and member associations.</p>
        </div>
        <a href="/teams/create" class="premium-btn flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Create New Team</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($teams as $team)
            <div class="glass-card p-6 flex flex-col group">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 font-bold group-hover:scale-110 transition-transform">
                        {{ substr($team->name, 0, 1) }}
                    </div>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $team->members->count() }} Members</span>
                </div>
                
                <h3 class="text-xl font-bold text-white mb-4 group-hover:text-indigo-400 transition-colors">{{ $team->name }}</h3>
                
                <div class="space-y-3 mb-6 flex-1">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-white/5 pb-2">Active Squad</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($team->members as $member)
                            <div title="{{ $member->name }}" class="w-8 h-8 rounded-full bg-slate-800 border-2 border-slate-900 flex items-center justify-center text-[10px] text-indigo-300 font-bold">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center space-x-2 pt-6 border-t border-white/5">
                    <button class="flex-1 px-4 py-2 rounded-xl bg-white/5 text-slate-400 text-xs font-bold hover:bg-white/10 hover:text-white transition-all">
                        Edit Squad
                    </button>
                </div>
            </div>
        @empty
            <div class="lg:col-span-3 glass-card p-20 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 bg-slate-800 rounded-3xl flex items-center justify-center text-slate-600 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">No teams yet</h3>
                    <p class="text-slate-400 mt-2">Start by creating a squad and inviting members.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
