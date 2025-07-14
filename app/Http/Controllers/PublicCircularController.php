<?php

namespace App\Http\Controllers;

use App\Models\Circular;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicCircularController extends Controller
{
    /**
     * Display a listing of all open job circulars.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Fetch only 'open' circulars, ordered by the most recent post date.
        // Eager load the count of jobs to display it efficiently.
        $circulars = Circular::withCount('jobs')
            ->where('status', 'open')
            ->where('last_date_of_submission', '>=', now()) // Ensure the circular is still open
            ->orderBy('post_date', 'desc')
            ->paginate(10); // Paginate the results

        return view('circulars.index', compact('circulars'));
    }

    /**
     * Display the specified circular and its job posts.
     *
     * @param  \App\Models\Circular  $circular
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Circular $circular)
    {
        // Ensure that users can only view circulars that are currently open.
        // If an admin wants to preview a closed one, a different method/policy would be needed.
        if ($circular->status === 'closed') {
            return redirect()->route('circulars.index')->with('error', 'The requested job circular is not currently open.');
        }

        // Eager load the related job posts, ordered by rank.
        $circular->load(['jobs' => function ($query) {
            $query->orderBy('rank', 'asc');
        }]);

        return view('circulars.show', compact('circular'));
    }
}
