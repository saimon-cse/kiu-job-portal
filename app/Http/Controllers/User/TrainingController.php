<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{
    /**
     * Display a listing of the user's training records.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Authorize this action using the UserTrainingPolicy.
        $this->authorize('viewAny', UserTraining::class);

        // Get all training records belonging to the authenticated user.
        $trainings = Auth::user()->trainings()->latest()->get();

        return view('user.training.index', compact('trainings'));
    }

    /**
     * Show the form for creating a new training record.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', UserTraining::class);

        return view('user.training.create');
    }

    /**
     * Store a newly created training record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', UserTraining::class);

        // Validate the incoming request data.
        $validatedData = $request->validate([
            'training_name' => 'required|string|max:255',
            'institute_name' => 'required|string|max:255',
            'period_from' => 'nullable|string|max:255',
            'period_to' => 'nullable|string|max:255',
            'certificate_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
        ]);

        // Handle the file upload if a certificate is provided.
        if ($request->hasFile('certificate_path')) {
            $path = $request->file('certificate_path')->store('training_certificates', 'public');
            $validatedData['certificate_path'] = $path;
        }

        // Create the new training record for the authenticated user.
        Auth::user()->trainings()->create($validatedData);

        return redirect()->route('training.index')->with('success', 'Training record added successfully.');
    }

    /**
     * Show the form for editing the specified training record.
     *
     * @param  \App\Models\UserTraining  $training
     * @return \Illuminate\View\View
     */
    public function edit(UserTraining $training)
    {
        // Authorize: Ensure the user owns this specific training record.
        $this->authorize('update', $training);

        return view('user.training.edit', compact('training'));
    }

    /**
     * Update the specified training record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserTraining  $training
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, UserTraining $training)
    {
        $this->authorize('update', $training);

        $validatedData = $request->validate([
            'training_name' => 'required|string|max:255',
            'institute_name' => 'required|string|max:255',
            'period_from' => 'nullable|string|max:255',
            'period_to' => 'nullable|string|max:255',
            'certificate_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Handle file upload for updates.
        if ($request->hasFile('certificate_path')) {
            // Delete the old certificate file if it exists.
            if ($training->certificate_path && Storage::disk('public')->exists($training->certificate_path)) {
                Storage::disk('public')->delete($training->certificate_path);
            }
            // Store the new file and update the path in the validated data.
            $path = $request->file('certificate_path')->store('training_certificates', 'public');
            $validatedData['certificate_path'] = $path;
        }

        // Update the training model instance.
        $training->update($validatedData);

        return redirect()->route('training.index')->with('success', 'Training record updated successfully.');
    }

    /**
     * Remove the specified training record from storage.
     *
     * @param  \App\Models\UserTraining  $training
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(UserTraining $training)
    {
        // Authorize: Ensure the user can only delete their own records.
        $this->authorize('delete', $training);

        // Delete the associated certificate file from storage if it exists.
        if ($training->certificate_path && Storage::disk('public')->exists($training->certificate_path)) {
            Storage::disk('public')->delete($training->certificate_path);
        }

        // Delete the database record.
        $training->delete();

        return redirect()->route('training.index')->with('success', 'Training record deleted successfully.');
    }
}
