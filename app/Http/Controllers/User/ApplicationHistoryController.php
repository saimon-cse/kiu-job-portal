<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationHistoryController extends Controller
{
    /**
     * Handle the incoming request.
     * Display a list of the authenticated user's job applications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        // Fetch all application histories for the logged-in user.
        // Eager load the 'job.circular' relationship to efficiently access deadline and post name.
        $applications = Auth::user()
            ->applicationHistory()
            // ->applicationHistories()
            ->with(['job', 'job.circular'])
            ->latest()
            ->paginate(15);

        return view('user.applications.index', compact('applications'));
    }
}
