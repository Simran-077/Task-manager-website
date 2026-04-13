@extends('layouts.app')

@section('content')

@php
$total = \App\Models\Task::count();
$completed = \App\Models\Task::where('status', 'completed')->count();
$pending = \App\Models\Task::where('status', 'pending')->count();
$overdue = \App\Models\Task::where('deadline', '<', now())
            ->where('status', '!=', 'completed')
            ->count();
@endphp

@php
$notifications = \App\Models\Notification::where('user_id', auth()->id())
    ->where('is_read', false)
    ->latest()
    ->get();
@endphp

<div class="grid md:grid-cols-4 gap-4 mb-6">

<div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
    <p class="text-gray-500">Total Tasks</p>
    <h2 class="text-3xl font-bold">{{ $total }}</h2>
</div>

<div class="bg-green-100 p-5 rounded-xl">
    <p>Completed</p>
    <h2 class="text-3xl font-bold text-green-600">{{ $completed }}</h2>
</div>

<div class="bg-yellow-100 p-5 rounded-xl">
    <p>Pending</p>
    <h2 class="text-3xl font-bold text-yellow-600">{{ $pending }}</h2>
</div>

<div class="bg-red-100 p-5 rounded-xl">
    <p>Overdue</p>
    <h2 class="text-3xl font-bold text-red-600">{{ $overdue }}</h2>
</div>

</div>
<div class="bg-white shadow rounded p-4">
    <h3 class="text-lg font-bold mb-3">
        🔔 Notifications ({{ $notifications->count() }})
    </h3>

    <ul>
        @foreach($notifications as $note)
            <li class="flex justify-between border-b py-2">
                {{ $note->message }}
                <a href="/notifications/{{ $note->id }}/read" class="text-green-500">✔</a>
            </li>
        @endforeach
    </ul>
</div>



@endsection