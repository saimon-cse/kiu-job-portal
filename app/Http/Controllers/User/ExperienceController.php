<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserExperience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', UserExperience::class);
        $experiences = auth()->user()->experiences()->latest()->get();
        return view('user.experience.index', compact('experiences'));
    }

    public function create()
    {
        $this->authorize('create', UserExperience::class);
        $experience = new UserExperience();
        return view('user.experience.create', compact('experience'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', UserExperience::class);
        $validated = $request->validate([
            'institute_name' => 'required|string|max:255',
            'post_and_scale' => 'required|string|max:255',
            'from_date' => 'required|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'institute_type' => 'nullable|string|max:255',
            'courses_taught' => 'nullable|string|max:255',
        ]);
        auth()->user()->experiences()->create($validated);
        return redirect()->route('experience.index')->with('success', 'Work experience added successfully.');
    }

    public function edit(UserExperience $experience)
    {
        $this->authorize('update', $experience);
        return view('user.experience.edit', compact('experience'));
    }

    public function update(Request $request, UserExperience $experience)
    {
        $this->authorize('update', $experience);
        $validated = $request->validate([
            'institute_name' => 'required|string|max:255',
            'post_and_scale' => 'required|string|max:255',
            'from_date' => 'required|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'institute_type' => 'nullable|string|max:255',
            'courses_taught' => 'nullable|string|max:255',
        ]);
        $experience->update($validated);
        return redirect()->route('experience.index')->with('success', 'Work experience updated successfully.');
    }

    public function destroy(UserExperience $experience)
    {
        $this->authorize('delete', $experience);
        $experience->delete();
        return redirect()->route('experience.index')->with('success', 'Work experience deleted successfully.');
    }
}
