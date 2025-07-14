<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageManagementController extends Controller
{
    /**
     * Show the form for managing user images (profile picture and signature).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('user.images.index', [
            'user' => $request->user(),
            'userProfile' => $request->user()->profile()->firstOrCreate([]),
        ]);
    }

    /**
     * Update the user's images.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:1024', // Max 1MB
            'signature_path' => 'nullable|image|mimes:jpeg,png,jpg|max:512',   // Max 512KB
        ]);

        $user = Auth::user();
        $userProfile = $user->profile()->firstOrCreate([]);

        // Handle Profile Picture Upload
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if it exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            // Store new picture and update the user model
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $path;
            $user->save();
        }

        // Handle Signature Upload
        if ($request->hasFile('signature_path')) {
            // Delete old signature if it exists
            if ($userProfile->signature_path && Storage::disk('public')->exists($userProfile->signature_path)) {
                Storage::disk('public')->delete($userProfile->signature_path);
            }
            // Store new signature and update the user profile model
            $path = $request->file('signature_path')->store('signatures', 'public');
            $userProfile->signature_path = $path;
            $userProfile->save();
        }

        return redirect()->route('images.index')->with('success', 'Images updated successfully.');
    }
}
