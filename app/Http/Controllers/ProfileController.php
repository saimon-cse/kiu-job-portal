<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     * This method now also fetches the user's extended profile data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        // Get the user's main profile record from the user_profiles table.
        // firstOrCreate([]) is a safe way to get the profile or create an empty one
        // if the user is editing their profile for the first time.
        // This prevents errors in the view if the profile record doesn't exist yet.
        $userProfile = $request->user()->profile()->firstOrCreate([]);

        return view('user.profile.edit', [
            'user' => $request->user(),
            'userProfile' => $userProfile, // Pass the extended profile to the view
        ]);
    }

    /**
     * Update the user's profile information.
     * This method now also validates and saves the extended profile data.
     *
     * @param \App\Http\Requests\ProfileUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        // This part handles the 'name' and 'email' from the `users` table,
        // using the validation from ProfileUpdateRequest.
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // --- NEW: VALIDATE AND PREPARE DATA FOR THE 'user_profiles' TABLE ---
        // We define validation rules for all the fields from your migration.
        $profileData = $request->validate([
            'full_name_bn' => 'nullable|string|max:255',
            'full_name_en' => 'nullable|string|max:255',
            'father_name_bn' => 'nullable|string|max:255',
            'father_name_en' => 'nullable|string|max:255',
            'mother_name_en' => 'nullable|string|max:255',
            'mother_name_bn' => 'nullable|string|max:255',
            'spouse_name_en' => 'nullable|string|max:255',
            'spouse_name_bn' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:255',
            'permanent_address_bn' => 'nullable|string|max:255',
            'permanent_address_en' => 'nullable|string|max:255',
            'present_address_bn' => 'nullable|string',
            'present_address_en' => 'nullable|string',
            'phone_mobile' => 'nullable|string|max:20',
            'additional_information' => 'nullable|string',
            'quota_information' => 'nullable|string',
        ]);

        // --- NEW: SAVE THE EXTENDED PROFILE DATA ---
        // We use the 'profile' relationship defined in the User model.
        // updateOrCreate is the perfect method here:
        // It finds the user's profile record and updates it,
        // or it creates a new one if it doesn't exist.
        $request->user()->profile()->updateOrCreate(
            ['user_id' => $request->user()->id], // The condition to find the record
            $profileData                       // The data to save
        );
        // --- END NEW ---

        // Save the changes to the `users` table model.
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
