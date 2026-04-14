<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Notification;
use App\Mail\TaskAssignedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class TaskController extends Controller
{

public function index(Request $request)
{
    $user = auth()->user();

    $query = \App\Models\Task::with('assignedUser', 'team');

    // Role filter
    if ($user->role != 'admin') {
        $query->where(function ($q) use ($user) {
            $q->where('assigned_to', $user->id)
              ->orWhereIn('team_id', $user->teams->pluck('id'));
        });
    }

    // Search
    if ($request->search) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // Status filter
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // Priority filter
    if ($request->priority) {
        $query->where('priority', $request->priority);
    }

    $tasks = $query->latest()->get();

    return view('tasks.index', compact('tasks'));
}

    public function create()
    {
        $users = User::all();
        $teams = \App\Models\Team::all();
        return view('tasks.create', compact('users', 'teams'));
    }

    public function store(Request $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'team_id' => $request->team_id,
            'description' => $request->description,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth()->id(),
            'deadline' => $request->deadline,
            'status' => 'pending',
        ]);

        \App\Models\Log::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'action' => 'created'
        ]);

        $user = User::find($request->assigned_to);

        if ($user) {
            \App\Services\AlertService::sendTaskAlert($user, $task);
        }

        Notification::create([
            'user_id' => $request->assigned_to,
            'message' => 'New task assigned: ' . $task->title,
        ]);

        return redirect('/tasks')->with('success', 'Task created successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        $task = \App\Models\Task::findOrFail($id);
        
        $oldStatus = $task->status;
        $newStatus = $request->status;

        if ($newStatus && in_array($newStatus, ['pending', 'progress', 'completed'])) {
            $task->status = $newStatus;
        } else {
            // Default toggle behavior
            if ($task->status == 'pending') {
                $task->status = 'progress';
            } elseif ($task->status == 'progress') {
                $task->status = 'completed';
            }
        }

        $task->save();

        if ($oldStatus != $task->status) {
            \App\Models\Log::create([
                'task_id' => $task->id,
                'user_id' => auth()->id(),
                'action' => 'status changed to ' . $task->status
            ]);
        }

        return back()->with('success', 'Task status updated');
    }

    public function destroy($id)
    {
        $task = \App\Models\Task::findOrFail($id);
        
        \App\Models\Log::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'action' => 'deleted task: ' . $task->title
        ]);

        $task->delete();

        return redirect('/tasks')->with('success', 'Task deleted');
    }

    public function edit($id)
    {
        $task = \App\Models\Task::findOrFail($id);
        $users = \App\Models\User::all();
        $teams = \App\Models\Team::all();

        return view('tasks.edit', compact('task', 'users', 'teams'));
    }

    public function update(Request $request, $id)
    {
        $task = \App\Models\Task::findOrFail($id);
        
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'team_id' => $request->team_id,
        ]);

        \App\Models\Log::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'action' => 'updated details'
        ]);

        return redirect('/tasks')->with('success', 'Task updated');
    }
}
