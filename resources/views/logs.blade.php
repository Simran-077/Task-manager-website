@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white">System Activity Logs</h1>
            <p class="text-slate-400">Detailed overview of all task movements and system events.</p>
        </div>
        
        <div class="flex items-center space-x-2 glass-card p-1 !rounded-xl">
            <a href="?filter=all" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('filter', 'all') == 'all' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:text-white' }} transition-all">All</a>
            <a href="?filter=hourly" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('filter') == 'hourly' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:text-white' }} transition-all">Hourly</a>
            <a href="?filter=daily" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('filter') == 'daily' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:text-white' }} transition-all">Daily</a>
            <a href="?filter=monthly" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('filter') == 'monthly' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:text-white' }} transition-all">Monthly</a>
            <a href="?filter=yearly" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('filter') == 'yearly' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:text-white' }} transition-all">Yearly</a>
        </div>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-white/5">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Task / Item</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Action Performed</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Timestamp</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($logs as $log)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    </div>
                                    <span class="font-medium text-white">{{ $log->task->title ?? 'System' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-md bg-white/5 text-slate-300 text-sm border border-white/5">
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 rounded-full bg-slate-700 flex items-center justify-center text-[10px] text-white">
                                        {{ substr($log->user->name ?? 'S', 0, 1) }}
                                    </div>
                                    <span class="text-sm text-slate-400">{{ $log->user->name ?? 'System' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm text-white font-medium">{{ $log->created_at->format('M d, Y') }}</span>
                                    <span class="text-xs text-slate-500">{{ $log->created_at->format('H:i:s') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-xs font-bold text-indigo-400 group-hover:underline cursor-default">
                                    {{ $log->created_at->diffForHumans() }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-slate-500 italic">No logs found for this period.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection