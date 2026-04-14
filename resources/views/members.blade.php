@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-white">Team Members</h1>
        <p class="text-slate-400">Collaborate with your team. Privacy settings are respected for members.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($members as $member)
            <div class="glass-card p-6 flex flex-col items-center text-center group">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-500/20 to-violet-600/20 flex items-center justify-center text-3xl font-bold text-indigo-400 mb-4 group-hover:rotate-6 transition-transform">
                    {{ substr($member->name, 0, 1) }}
                </div>
                
                <h3 class="text-xl font-bold text-white mb-1 group-hover:text-indigo-400 transition-colors">{{ $member->name }}</h3>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-6">{{ $member->role }}</span>

                <div class="w-full space-y-3 pt-6 border-t border-white/5">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Email</span>
                        <span class="text-slate-300">{{ $member->getVisibleEmail(auth()->user()) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Phone</span>
                        <span class="text-slate-300">{{ $member->getVisiblePhone(auth()->user()) }}</span>
                    </div>
                </div>

                @if(auth()->user()->isAdmin() && auth()->id() !== $member->id)
                    <div class="mt-6 pt-6 border-t border-white/5 w-full flex justify-center space-x-2">
                        <button class="px-4 py-2 rounded-lg bg-indigo-500/10 text-indigo-400 text-xs font-bold hover:bg-indigo-500 hover:text-white transition-all">
                            Manage Tasks
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
