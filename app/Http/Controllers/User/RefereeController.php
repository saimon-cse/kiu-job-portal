<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Referee;
use Illuminate\Http\Request;

class RefereeController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Referee::class);
        $referees = auth()->user()->referees()->orderBy('rank')->get();
        return view('user.referee.index', compact('referees'));
    }

    public function create()
    {
        $this->authorize('create', Referee::class);
        return view('user.referee.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Referee::class);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);
        auth()->user()->referees()->create($validated);
        return redirect()->route('referee.index')->with('success', 'Referee added successfully.');
    }

    public function edit(Referee $referee)
    {
        $this->authorize('update', $referee);
        return view('user.referee.edit', compact('referee'));
    }

    public function update(Request $request, Referee $referee)
    {
        $this->authorize('update', $referee);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);
        $referee->update($validated);
        return redirect()->route('referee.index')->with('success', 'Referee updated successfully.');
    }

    public function destroy(Referee $referee)
    {
        $this->authorize('delete', $referee);
        $referee->delete();
        return redirect()->route('referee.index')->with('success', 'Referee deleted successfully.');
    }
}
