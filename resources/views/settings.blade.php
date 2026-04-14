@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="flex items-center space-x-4 mb-8">
        <div class="w-12 h-12 glass-card !rounded-2xl flex items-center justify-center text-indigo-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-white">Account Settings</h1>
            <p class="text-slate-400">Manage your profile, privacy, and notifications.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/settings" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Profile Info -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profile Information
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="premium-input w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="premium-input w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ auth()->user()->phone }}" class="premium-input w-full" placeholder="+1 (555) 000-0000">
                    </div>
                </div>
            </div>

            <!-- Privacy Controls -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Privacy Settings
                </h2>
                
                <div class="space-y-6">
                    <p class="text-sm text-slate-400">Control what information other team members can see. Note: Admin (your boyfriend) can always see this information.</p>
                    
                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="show_email" {{ auth()->user()->show_email ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-700 rounded-full peer peer-checked:bg-indigo-600 transition-colors"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <span class="text-slate-300 group-hover:text-white transition-colors">Show email to team members</span>
                    </label>

                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="show_phone" {{ auth()->user()->show_phone ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-700 rounded-full peer peer-checked:bg-indigo-600 transition-colors"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <span class="text-slate-300 group-hover:text-white transition-colors">Show phone number to team members</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Notification Preferences -->
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold text-white mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                Notification Channels
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <label class="p-4 rounded-2xl border border-white/5 bg-white/5 hover:border-indigo-500/30 cursor-pointer transition-all">
                    <input type="checkbox" name="notify_email" {{ auth()->user()->notify_email ? 'checked' : '' }} class="mb-3 block">
                    <span class="block font-medium text-white">Email Notifications</span>
                    <span class="text-xs text-slate-400">Receive updates via your email address.</span>
                </label>

                <label class="p-4 rounded-2xl border border-white/5 bg-white/5 hover:border-violet-500/30 cursor-pointer transition-all">
                    <input type="checkbox" name="notify_sms" {{ auth()->user()->notify_sms ? 'checked' : '' }} class="mb-3 block">
                    <span class="block font-medium text-white">SMS Messages</span>
                    <span class="text-xs text-slate-400">Get a text message for urgent tasks.</span>
                </label>

                <label class="p-4 rounded-2xl border border-white/5 bg-white/5 hover:border-rose-500/30 cursor-pointer transition-all">
                    <input type="checkbox" name="notify_call" {{ auth()->user()->notify_call ? 'checked' : '' }} class="mb-3 block">
                    <span class="block font-medium text-white">Phone Call Alerts</span>
                    <span class="text-xs text-slate-400">Automated ring for overdue tasks.</span>
                </label>
            </div>
        </div>

        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold text-white mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.828 2.828a2 2 0 010 2.828l-8.486 8.485M7 17l.01.01"></path></svg>
                Appearance & Theme
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <label class="p-4 rounded-2xl border border-white/5 bg-white/5 hover:border-indigo-500/30 cursor-pointer transition-all flex items-center space-x-4">
                    <input type="radio" name="theme" value="dark" {{ auth()->user()->theme == 'dark' ? 'checked' : '' }}>
                    <div>
                        <span class="block font-medium text-white">Midnight (Dark)</span>
                        <span class="text-xs text-slate-400">Deep indigo and violet gradients.</span>
                    </div>
                </label>

                <label class="p-4 rounded-2xl border border-white/5 bg-white/5 hover:border-indigo-500/30 cursor-pointer transition-all flex items-center space-x-4">
                    <input type="radio" name="theme" value="light" {{ auth()->user()->theme == 'light' ? 'checked' : '' }}>
                    <div>
                        <span class="block font-medium text-white">Cloud (Light)</span>
                        <span class="text-xs text-slate-400">Clean, crisp, and bright layout.</span>
                    </div>
                </label>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="premium-btn">
                Save All Settings
            </button>
        </div>
    </form>
</div>
@endsection