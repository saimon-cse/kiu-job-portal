<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // It's good practice to import Auth facade

class EducationController extends Controller
{
    /**
     * Display a listing of the user's education records.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Authorize: Checks the 'viewAny' method in UserEducationPolicy.
        // Ensures only authenticated users can see this page.
        $this->authorize('viewAny', UserEducation::class);

        // Get all education records that belong to the currently logged-in user.
        // We use the 'educations' relationship defined in the User model.
        $educations = Auth::user()->educations()->latest()->get();

        return view('user.education.index', compact('educations'));
    }

    /**
     * Show the form for creating a new education record.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Authorize: Checks the 'create' method in UserEducationPolicy.
        $this->authorize('create', UserEducation::class);

        return view('user.education.create');
    }

    /**
     * Store a newly created education record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', UserEducation::class);

        // Validate the form data.
        $validatedData = $request->validate([
            'exam_name' => 'required|string|max:255',
            'institution_name' => 'required|string|max:255',
            'passing_year' => 'required|digits:4|integer|min:1950|max:' . date('Y'),
            'gpa_or_cgpa' => 'nullable|string|max:50',
            'course_studied' => 'nullable|string|max:255',
        ]);

        // Create the new education record and automatically associate it with the logged-in user.
        Auth::user()->educations()->create($validatedData);

        return redirect()->route('education.index')->with('success', 'Education record added successfully.');
    }

    /**
     * Show the form for editing the specified education record.
     *
     * @param  \App\Models\UserEducation  $education
     * @return \Illuminate\View\View
     */
    public function edit(UserEducation $education)
    {
        // Authorize: Checks the 'update' method in UserEducationPolicy.
        // This is CRITICAL. It ensures the user owns this specific record.
        // If not, Laravel will automatically show a 403 Forbidden page.
        $this->authorize('update', $education);

        return view('user.education.edit', compact('education'));
    }

    /**
     * Update the specified education record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserEducation  $education
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, UserEducation $education)
    {
        $this->authorize('update', $education);

        // Validate the form data again for the update.
        $validatedData = $request->validate([
            'exam_name' => 'required|string|max:255',
            'institution_name' => 'required|string|max:255',
            'passing_year' => 'required|digits:4|integer|min:1950|max:' . date('Y'),
            'gpa_or_cgpa' => 'nullable|string|max:50',
            'course_studied' => 'nullable|string|max:255',
        ]);

        // Update the existing model instance with the validated data.
        $education->update($validatedData);

        return redirect()->route('education.index')->with('success', 'Education record updated successfully.');
    }

    /**
     * Remove the specified education record from storage.
     *
     * @param  \App\Models\UserEducation  $education
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(UserEducation $education)
    {
        // Authorize: Checks the 'delete' method in UserEducationPolicy.
        // Ensures the user can only delete their own records.
        $this->authorize('delete', $education);

        $education->delete();

        return redirect()->route('education.index')->with('success', 'Education record deleted successfully.');
    }
}
