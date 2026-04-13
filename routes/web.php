<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;

Route::get('/', function () {
    return view('welcome');
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
Route::get('/teams/create', [TeamController::class, 'create'])->middleware('admin');
Route::post('/teams', [TeamController::class, 'store'])->middleware('admin');

Route::get('/settings', function () {
    return view('settings');
})->middleware('auth');

Route::post('/settings', function (\Illuminate\Http\Request $request) {
    $user = auth()->user();

    $user->update([
        'show_email' => $request->has('show_email'),
        'show_phone' => $request->has('show_phone'),
    ]);

    return back()->with('success', 'Settings updated');
})->middleware('auth');

Route::get('/notifications/{id}/read', function ($id) {
    $note = \App\Models\Notification::findOrFail($id);
    $note->update(['is_read' => true]);

    return redirect('/dashboard');
})->middleware('auth');

Route::get('/logs', function () {
    $logs = \App\Models\Log::with('task')->latest()->get();
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