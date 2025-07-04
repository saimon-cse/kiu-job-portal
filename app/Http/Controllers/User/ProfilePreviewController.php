<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfilePreviewController extends Controller
{
    /**
     * Display the user's complete profile information in a read-only format.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request): View
    {
        // Get the currently authenticated user
        $user = $request->user();

        // Eager load all related profile data in a single query for performance
        $user->load([
            'profile',
            'educations' => function ($query) {
                $query->latest();
            },
            'experiences' => function ($query) {
                $query->latest('from_date');
            },
            'trainings' => function ($query) {
                $query->latest();
            },
            'languageProficiencies' => function ($query) {
                $query->orderBy('rank');
            },
            'referees' => function ($query) {
                $query->orderBy('rank');
            },
            'documents' => function ($query) {
                $query->latest();
            },
        ]);

        return view('user.profile_preview.show', compact('user'));
    }
}
