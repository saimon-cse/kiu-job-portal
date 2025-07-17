<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\ApplicationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    /**
     * Creates a PENDING application record and redirects to payment if needed.
     */
    public function store(Request $request, Job $job)
    {
        $user = Auth::user();

        // Check if a 'submitted' application already exists for this job
        $existingApplication = ApplicationHistory::where('user_id', $user->id)
            ->where('job_id', $job->id)
            ->where('status', 'submitted')
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already successfully applied for this job.');
        }

        // If no payment is required...
        if ($job->application_fee <= 0) {
            // (can have logic here to create a 'submitted' record directly and take a snapshot)
            return redirect()->route('dashboard')->with('success', 'Application submitted successfully (no fee required).');
        }


        $application = ApplicationHistory::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'status' => 'pending',
            'due_amount' => $job->application_fee,
        ]);


        return redirect()->route('applications.history.index')
            ->with('success', 'Application saved! Please complete the payment to finalize your submission.');
        // Redirect to the payment initiation route, passing the new application record
        // return redirect()->route('payment.pay', ['application' => $application->id]);
    }

    public function destroy(ApplicationHistory $application)
    {

        if ($application->user_id !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }


        if ($application->status !== 'pending') {
            return back()->with('error', 'Cannot delete an application that has already been processed.');
        }


        $application->delete();

        return back()->with('success', 'Your pending application has been successfully deleted.');
    }


}

