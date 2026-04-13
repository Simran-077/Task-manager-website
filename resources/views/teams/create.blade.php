@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">

    <!-- Title -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">👥 Create Team</h2>
        <a href="/tasks" class="text-gray-500 hover:text-black">← Back</a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Form -->
    <form method="POST" action="/teams" class="space-y-5">
        @csrf

        <!-- Team Name -->
        <div>
            <label class="block font-semibold mb-1">
                Team Name <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                name="name"
                value="{{ old('name') }}"
                placeholder="Enter team name"
                class="w-full border p-3 rounded focus:ring-2 focus:ring-blue-400"
            >
        </div>

        <!-- Members -->
        <div>
            <label class="block font-semibold mb-2">Select Members</label>

            <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto border p-3 rounded">
                @foreach($users as $user)
                    <label class="flex items-center space-x-2">
                        <input 
                            type="checkbox" 
                            name="members[]" 
                            value="{{ $user->id }}"
                            class="accent-blue-500"
                        >
                        <span>{{ $user->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Button -->
        <div class="text-right">
            <button 
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded"
                onclick="this.disabled=true; this.form.submit();"
            >
                Create Team
            </button>
        </div>

    </form>

</div>

@endsection