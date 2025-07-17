<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Circular;
use Illuminate\Http\Request;

class JobManagementController extends Controller
{
    /**
     * Display a listing of all job posts within a specific circular.
     * This is the intermediate page.
     *
     * @param  \App\Models\Circular  $circular
     * @return \Illuminate\View\View
     */
    public function index(Circular $circular)
    {
        // Use a permission that allows viewing job/circular details
        $this->authorize('manage-circulars');

        // Eager load the counts for each job post for efficiency
        $jobs = $circular->jobs()->withCount([
            'applications',
            'applications as paid_applications_count' => function ($query) {
                $query->where('status', 'submitted'); // Assuming 'submitted' means paid
            },
            'applications as unpaid_applications_count' => function ($query) {
                $query->where('status', 'pending');
            },
            'applications as eligible_applications_count' => function ($query) {
                $query->where('status', 'shortlisted'); // Or 'accepted', based on your definition
            }
        ])->orderBy('rank')->paginate(15);

        return view('admin.jobs.index', compact('circular', 'jobs'));
    }
}
