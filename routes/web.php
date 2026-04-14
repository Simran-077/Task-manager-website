<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\DB;


Route::get('/', function () {
    return redirect('/dashboard');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';

Route::get('/admin', function () {
    return "Admin Panel";
})->middleware('admin');
Route::get('/tasks/create', [TaskController::class, 'create'])->middleware('admin');
Route::post('/tasks', [TaskController::class, 'store'])->middleware('admin');
Route::get('/tasks', [TaskController::class, 'index'])->middleware('auth');
Route::post('/tasks/{id}/status', [TaskController::class, 'updateStatus'])->middleware('auth');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->middleware('auth');
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->middleware('auth');
Route::put('/tasks/{id}', [TaskController::class, 'update'])->middleware('auth');
Route::get('/teams', [TeamController::class, 'index'])->middleware('admin');
Route::get('/teams/create', [TeamController::class, 'create'])->middleware('admin');
Route::post('/teams', [TeamController::class, 'store'])->middleware('admin');

Route::get('/settings', function () {
    return view('settings');
})->middleware('auth');

Route::post('/settings', function (\Illuminate\Http\Request $request) {
    $user = auth()->user();

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'show_email' => $request->has('show_email'),
        'show_phone' => $request->has('show_phone'),
        'notify_email' => $request->has('notify_email'),
        'notify_sms' => $request->has('notify_sms'),
        'notify_call' => $request->has('notify_call'),
        'theme' => $request->theme,
    ]);

    return back()->with('success', 'Settings updated successfully!');
})->middleware('auth');

Route::get('/notifications/{id}/read', function ($id) {
    $note = \App\Models\Notification::findOrFail($id);
    $note->update(['is_read' => true]);

    return redirect('/dashboard');
})->middleware('auth');

Route::get('/members', function () {
    $members = \App\Models\User::all();
    return view('members', compact('members'));
})->middleware('auth');

Route::get('/logs', function (Illuminate\Http\Request $request) {
    $filter = $request->query('filter', 'all');
    $query = \App\Models\Log::with(['task', 'user'])->latest();

    if ($filter == 'hourly') {
        $query->where('created_at', '>=', now()->subHour());
    } elseif ($filter == 'daily') {
        $query->where('created_at', '>=', now()->subDay());
    } elseif ($filter == 'monthly') {
        $query->where('created_at', '>=', now()->subMonth());
    } elseif ($filter == 'yearly') {
        $query->where('created_at', '>=', now()->subYear());
    }

    $logs = $query->get();
    return view('logs', compact('logs'));
})->middleware('admin');

Route::post('/tasks/{id}/comment', function (Illuminate\Http\Request $request, $id) {

    \App\Models\Comment::create([
        'task_id' => $id,
        'user_id' => auth()->id(),
        'comment' => $request->comment
    ]);

    return back();
})->middleware('auth');


Route::get('/tables', function () {
    return DB::select("SELECT tablename FROM pg_tables WHERE schemaname='public'");
});