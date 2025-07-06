<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PublicationType;
use App\Models\UserPublication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicationController extends Controller
{
    /**
     * Display a listing of the user's publications.
     */
    public function index()
    {
        $this->authorize('viewAny', UserPublication::class);

        // Eager load the 'publicationType' relationship to avoid N+1 queries in the view
        $publications = Auth::user()->publications()->with('publicationType')->orderBy('rank')->get();

        return view('user.publication.index', compact('publications'));
    }

    /**
     * Show the form for creating a new publication.
     */
    public function create()
    {
        $this->authorize('create', UserPublication::class);

        // Fetch all publication types to populate the dropdown in the form
        $publicationTypes = PublicationType::orderBy('name')->pluck('name', 'id');

        return view('user.publication.create', compact('publicationTypes'));
    }

    /**
     * Store a newly created publication in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', UserPublication::class);

        $validatedData = $request->validate([
            'title' => 'required|string',
            'doi' => 'nullable|string',
            'publication_type_id' => 'required|exists:publication_types,id',
            // 'rank' => 'nullable|integer',
        ]);

        // Create the new publication and associate it with the logged-in user
        Auth::user()->publications()->create($validatedData);

        return redirect()->route('publication.index')->with('success', 'Publication added successfully.');
    }

    /**
     * Show the form for editing the specified publication.
     */
    public function edit(UserPublication $publication)
    {
        // Authorize: Ensure the user owns this specific publication record.
        $this->authorize('update', $publication);

        $publicationTypes = PublicationType::orderBy('name')->pluck('name', 'id');

        return view('user.publication.edit', compact('publication', 'publicationTypes'));
    }

    /**
     * Update the specified publication in storage.
     */
    public function update(Request $request, UserPublication $publication)
    {
        $this->authorize('update', $publication);

        $validatedData = $request->validate([
            'title' => 'required|string',
            'publication_type_id' => 'required|exists:publication_types,id',
            // 'rank' => 'nullable|integer',
            'doi' => 'nullable|string'
        ]);

        $publication->update($validatedData);

        return redirect()->route('publication.index')->with('success', 'Publication updated successfully.');
    }

    /**
     * Remove the specified publication from storage.
     */
    public function destroy(UserPublication $publication)
    {
        // Authorize: Ensure the user can only delete their own records.
        $this->authorize('delete', $publication);

        $publication->delete();

        return redirect()->route('publication.index')->with('success', 'Publication deleted successfully.');
    }

     /**
     * Reorder the publications based on a new order of IDs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reorder(Request $request)
    {
        // Authorize that the user can generally manage their publications.
        // We don't need to check every single item for ownership here,
        // as the query below already scopes to the authenticated user.
        $this->authorize('create', UserPublication::class);

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer', // Ensure every item in the array is an integer
        ]);

        $user = Auth::user();

        // Loop through the received order array
        foreach ($request->order as $index => $publicationId) {
            // Update the rank for each publication belonging to the current user
            $user->publications()
                 ->where('id', $publicationId)
                 ->update(['rank' => $index]);
        }

        // Return a JSON response to indicate success
        return response()->json(['status' => 'success', 'message' => 'Order updated successfully.']);
    }


}
