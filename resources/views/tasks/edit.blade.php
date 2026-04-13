@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">

<h2 class="text-2xl font-bold mb-6">✏ Edit Task</h2>

<form method="POST" action="/tasks/{{ $task->id }}" class="space-y-5">
@csrf
@method('PUT')

<div>
<label class="block mb-1 font-semibold">Task Title</label>
<input type="text" name="title"
value="{{ $task->title }}"
class="w-full border p-3 rounded">
</div>

<div>
<label>Description</label>
<textarea name="description" class="w-full border p-3 rounded">{{ $task->description }}</textarea>
</div>

<div>
<label>Assign To</label>
<select name="assigned_to" class="w-full border p-3 rounded">
@foreach($users as $user)
<option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
{{ $user->name }}
</option>
@endforeach
</select>
</div>

<div>
<label>Deadline</label>
<input type="datetime-local"
value="{{ date('Y-m-d\TH:i', strtotime($task->deadline)) }}"
name="deadline"
class="w-full border p-3 rounded">
</div>

<div class="text-right">
<button class="bg-green-500 text-white px-6 py-2 rounded">
Update Task
</button>
</div>

</form>

<div class="mt-8 bg-white p-4 rounded shadow">
<h3 class="font-bold mb-3">💬 Comments</h3>

@foreach($task->comments as $comment)
<div class="border-b py-2">
<strong>{{ $comment->user->name }}</strong>:
{{ $comment->comment }}
</div>
@endforeach

<form method="POST" action="/tasks/{{ $task->id }}/comment" class="mt-4">
@csrf
<input name="comment" placeholder="Write comment..."
class="w-full border p-2 rounded mb-2">
<button class="bg-blue-500 text-white px-4 py-2 rounded">
Send
</button>
</form>

</div>

</div>

@endsection