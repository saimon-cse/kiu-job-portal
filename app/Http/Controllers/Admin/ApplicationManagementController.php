<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationHistory;
use App\Models\Circular;
use Illuminate\Http\Request;
use App\Models\Job;
class ApplicationManagementController extends Controller
{
    /**
     * Display a listing of all submitted applications for a specific circular.
     *
     * @param  \App\Models\Circular  $circular
     * @return \Illuminate\View\View
     */
    public function index(Circular $circular)
    {
        $this->authorize('view-applications');
        $jobIds = $circular->jobs()->pluck('id');
        $applications = ApplicationHistory::whereIn('job_id', $jobIds)
            ->where('status', 'submitted')
            ->with(['user', 'job'])
            ->latest()->paginate(20);
        return view('admin.applications.index', compact('applications', 'circular'));
    }

        public function indexForJob(Request $request, Job $job)
    {
        $this->authorize('view-applications');

        $query = $job->applications()->with('user');

        // Optional: Add filtering by status on this page too
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(20)->withQueryString();

        return view('admin.applications.index_for_job', compact('applications', 'job'));
    }

     /**
     * NEW: Display a listing of all applications for a SPECIFIC job post.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\View\View
     */
     public function showApplicationsForJob(Job $job)
    {
        // Authorize the action.
        $this->authorize('view-applications');

        // Fetch all submitted applications for this specific job.
        // Eager load the 'user' relationship for efficiency.
        $applications = ApplicationHistory::where('job_id', $job->id)
            ->where('status', 'submitted')
            ->with('user')
            ->latest()
            ->paginate(20);

        // We pass the $job object to the view to display its details.
        return view('admin.applications.index_for_job', compact('applications', 'job'));
    }


    /**
     * NEW: Update the status of multiple applications at once.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkUpdateStatus(Request $request)
    {
        $this->authorize('update-application-status');

        $request->validate([
            'application_ids' => 'required|array',
            'application_ids.*' => 'integer|exists:applications_history,id', // Ensure all IDs are valid
            'status' => 'required|string|in:submitted,reviewed,shortlisted,accepted,rejected',
        ]);

        $applicationIds = $request->input('application_ids');
        $newStatus = $request->input('status');

        // Update all the selected applications that belong to the specified job post.
        // This query ensures an admin can't accidentally update applications from other jobs.
        ApplicationHistory::whereIn('id', $applicationIds)
            ->update(['status' => $newStatus]);

        return back()->with('success', count($applicationIds) . ' application(s) have been updated to \'' . $newStatus . '\'.');
    }


    /**
     * Display the specified application, including its full data snapshot.
     *
     * @param  \App\Models\ApplicationHistory  $application
     * @return \Illuminate\View\View
     */
    public function show(ApplicationHistory $application)
    {
        $this->authorize('view-applications');

        // To view the snapshot, we need to fetch all related history records.
        // The relationship key for all history tables is 'job_id' and 'user_id'.
        $snapshot = [
            'profile' => $application->user->profileHistory()->where('job_id', $application->job_id)->first(),
            'educations' => $application->user->educationHistory()->where('job_id', $application->job_id)->orderBy('rank')->get(),
            'experiences' => $application->user->experienceHistory()->where('job_id', $application->job_id)->orderBy('rank')->get(),
            'publications' => $application->user->publicationHistory()->where('job_id', 'job_id')->with('publicationType')->orderBy('rank')->get(),
            'trainings' => $application->user->trainingHistory()->where('job_id', $application->job_id)->orderBy('rank')->get(),
            'languages' => $application->user->languageHistory()->where('job_id', $application->job_id)->orderBy('rank')->get(),
            'referees' => $application->user->refereeHistory()->where('job_id', $application->job_id)->orderBy('rank')->get(),
            'awards' => $application->user->awardHistory()->where('job_id', $application->job_id)->orderBy('rank')->get(),
            'documents' => $application->user->documentHistory()->where('job_id', $application->job_id)->get(),
        ];

        return view('admin.applications.show', compact('application', 'snapshot'));
    }

    /**
     * Update the status of the specified application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApplicationHistory  $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, ApplicationHistory $application)
    {
        $this->authorize('update-application-status');

        $validated = $request->validate([
            'status' => 'required|string|in:submitted,reviewed,shortlisted,rejected,accepted',
        ]);

        $application->update(['status' => $validated['status']]);

        return back()->with('success', "Application status has been updated to '{$validated['status']}'.");
    }
}
