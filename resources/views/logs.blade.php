@extends('layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">Activity Logs</h2>

<div class="bg-white p-4 rounded shadow">

<table class="w-full text-center">
<tr class="border-b">
<th>Task</th>
<th>Action</th>
<th>Time</th>
</tr>

@foreach($logs as $log)
<tr class="border-b">
<td>{{ $log->task->title ?? '' }}</td>
<td>{{ $log->action }}</td>
<td>{{ $log->created_at }}</td>
</tr>
@endforeach

</table>

</div>

@endsection