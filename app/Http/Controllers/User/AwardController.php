<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserAward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AwardController extends Controller
{
    /**
     * Display a listing of the user's awards.
     */
    public function index()
    {
        $this->authorize('viewAny', UserAward::class);
        $awards = Auth::user()->awards()->orderBy('rank', 'asc')->get();
        return view('user.award.index', compact('awards'));
    }

    /**
     * Show the form for creating a new award.
     */
    public function create()
    {
        $this->authorize('create', UserAward::class);
        return view('user.award.create');
    }

    /**
     * Store a newly created award in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', UserAward::class);
        $validatedData = $this->validateAward($request);
        Auth::user()->awards()->create($validatedData);
        return redirect()->route('award.index')->with('success', 'Award added successfully.');
    }

    /**
     * Show the form for editing the specified award.
     */
    public function edit(UserAward $award)
    {
        $this->authorize('update', $award);
        return view('user.award.edit', compact('award'));
    }

    /**
     * Update the specified award in storage.
     */
    public function update(Request $request, UserAward $award)
    {
        $this->authorize('update', $award);
        $validatedData = $this->validateAward($request);
        $award->update($validatedData);
        return redirect()->route('award.index')->with('success', 'Award updated successfully.');
    }

    /**
     * Remove the specified award from storage.
     */
    public function destroy(UserAward $award)
    {
        $this->authorize('delete', $award);
        $award->delete();
        return redirect()->route('award.index')->with('success', 'Award deleted successfully.');
    }

    /**
     * Reorder the awards based on a new order of IDs.
     */
    public function reorder(Request $request)
    {
        $this->authorize('create', UserAward::class);
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        foreach ($request->order as $index => $awardId) {
            Auth::user()->awards()->where('id', $awardId)->update(['rank' => $index]);
        }

        return response()->json(['status' => 'success', 'message' => 'Awards order updated successfully.']);
    }

    /**
     * Private helper method to validate award data.
     */
    private function validateAward(Request $request)
    {
        return $request->validate([
            'award_name' => 'required|string|max:255',
            'awarding_body' => 'required|string|max:255',
            'year_received' => 'required|digits:4|integer|min:1950|max:' . date('Y'),
            'description' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'rank' => 'nullable|integer',
        ]);
    }
}
