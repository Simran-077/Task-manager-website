@extends('layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">Privacy Settings</h2>

<form method="POST" action="/settings" class="bg-white p-4 rounded shadow">
@csrf

<label>
<input type="checkbox" name="show_email" {{ auth()->user()->show_email ? 'checked' : '' }}>
Show Email
</label><br><br>

<label>
<input type="checkbox" name="show_phone" {{ auth()->user()->show_phone ? 'checked' : '' }}>
Show Phone
</label><br><br>

<button class="bg-green-500 text-white px-4 py-2 rounded">Save</button>

</form>

@endsection