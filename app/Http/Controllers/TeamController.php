<?php

namespace App\Http\Controllers;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('members')->latest()->get();
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        $users = User::all();
        return view('teams.create', compact('users'));
    }

public function store(Request $request)
{
    $team = Team::create([
        'name' => $request->name,
        'created_by' => auth()->id()
    ]);

    // attach selected members
    $team->members()->attach($request->members);

    return redirect('/teams/create')->with('success', 'Team created successfully');
}
}
