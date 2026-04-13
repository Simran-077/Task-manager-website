@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">

<h2 class="text-2xl font-bold mb-6">➕ Create Task</h2>

<form method="POST" action="/tasks" class="space-y-5">
@csrf

<!-- Title -->
<div>
<label class="block mb-1 font-semibold">Task Title</label>
<input type="text" name="title"
class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
placeholder="Enter task title">
</div>

<!-- Description -->
<div>
<label class="block mb-1 font-semibold">Description</label>
<textarea name="description"
class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
placeholder="Task details"></textarea>
</div>

<div>
<label class="block mb-1 font-semibold">Priority</label>
<select name="priority"
class="w-full border p-3 rounded">
    <option value="low">🟢 Low</option>
    <option value="medium" selected>🟡 Medium</option>
    <option value="high">🔴 High</option>
</select>
</div>

<!-- Team -->
<div>
<label class="block mb-1 font-semibold">Team</label>
<select name="team_id"
class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
<option value="">Select Team</option>
@foreach(\App\Models\Team::all() as $team)
<option value="{{ $team->id }}">{{ $team->name }}</option>
@endforeach
</select>
</div>

<!-- Assign -->
<div>
<label class="block mb-1 font-semibold">Assign To</label>
<select name="assigned_to"
class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
@foreach($users as $user)
<option value="{{ $user->id }}">{{ $user->name }}</option>
@endforeach
</select>
</div>

<!-- Deadline -->
<div>
<label class="block mb-1 font-semibold">Deadline</label>
<input type="datetime-local" name="deadline"
class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
</div>

<!-- Button -->
<div class="text-right">
<button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
Create Task
</button>
</div>

</form>

</div>

@endsection