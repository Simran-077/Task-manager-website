@extends('layouts.app')

@section('content')

<div class="flex justify-between mb-4">
    <h2 class="text-2xl font-bold">📋 Tasks</h2>
    <a href="/tasks/create" class="bg-blue-500 text-white px-4 py-2 rounded">+ Add Task</a>
</div>

<form method="GET" action="/tasks" class="mb-4 flex gap-2">

<input 
    type="text" 
    name="search"
    placeholder="Search task..."
    value="{{ request('search') }}"
    class="border p-2 rounded w-full"
>

<select name="status" class="border p-2 rounded">
    <option value="">All Status</option>
    <option value="pending">Pending</option>
    <option value="progress">Progress</option>
    <option value="completed">Completed</option>
</select>

<select name="priority" class="border p-2 rounded">
    <option value="">All Priority</option>
    <option value="low">Low</option>
    <option value="medium">Medium</option>
    <option value="high">High</option>
</select>

<button class="bg-blue-500 text-white px-4 rounded">Search</button>

</form>

<div class="bg-white shadow rounded p-4 overflow-x-auto">

<table class="w-full text-center">
<thead>
<tr class="border-b font-semibold">
    <th>Title</th>
    <th>Assigned</th>
    <th>Status</th>
    <th>Deadline</th>
    <th>Team</th>
    <th>Priority</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($tasks as $task)
<tr class="border-b">

<td>{{ $task->title }}</td>

<td>
@if ($task->assignedUser->show_email || auth()->user()->role == 'admin')
    {{ $task->assignedUser->email }}
@else
    Hidden
@endif
</td>

<td>
@if(now()->gt($task->deadline) && $task->status != 'completed')
    <span class="text-red-500 font-bold">Overdue</span>
@elseif($task->status == 'pending')
    <span class="text-yellow-500">Pending</span>
@elseif($task->status == 'progress')
    <span class="text-blue-500">Progress</span>
@else
    <span class="text-green-500">Done</span>
@endif
</td>

<td>{{ $task->deadline }}</td>
<td>{{ $task->team->name ?? 'N/A' }}</td>
<td>
@if($task->priority == 'high')
    <span class="text-red-500 font-bold">High</span>
@elseif($task->priority == 'medium')
    <span class="text-yellow-500">Medium</span>
@else
    <span class="text-green-500">Low</span>
@endif
</td>

<td class="space-x-2">
<a href="/tasks/{{ $task->id }}/edit" class="text-blue-500">Edit</a>
</td>

</tr>
@endforeach
</tbody>

</table>
</div>

@endsection