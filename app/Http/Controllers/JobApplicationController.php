<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\UserEducationHistory;
use App\Models\UserExperienceHistory;
use App\Models\UserPublicationHistory;
use App\Models\LanguageProficiencyHistory;
use App\Models\RefereeHistory;
use App\Models\UserTrainingHistory;
use App\Models\UserDocumentHistory;
use App\Models\UserProfileHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobApplicationController extends Controller
{
    /**
     * Store a newly created job application and create a data snapshot.
     */
    public function store(Request $request, Job $job)
    {
        $user = Auth::user();

        // Check already applied for this job
        $existingApplication = JobApplication::where('user_id', $user->id)
            ->where('job_id', $job->id)
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }


        DB::beginTransaction();

        try {
            // Create the main Job Application record
            $application = JobApplication::create([
                'user_id' => $user->id,
                'job_id' => $job->id,
                'status' => 'submitted', // 'pending' if payment is required first
            ]);

            //  Create the Data Snapshot
            $this->createSnapshot($user, $job->id);

            // here the payment logic can be implemented
            //  (Optional) Create Payment Record
            /////////////////////
            //    Payment Logic
            //////////////////////


            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Your application has been submitted successfully!');

        } catch (\Exception $e) {

            DB::rollBack();


            Log::error('Job Application Snapshot Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while submitting your application. Please try again.');
        }
    }

    /**
     * Copies a user's current profile data to the history tables.
     *
     * @param \App\Models\User $user The user whose data is being snapshotted.
     * @param int $jobId The ID of the job being applied for.
     */
    private function createSnapshot($user, $jobId)
    {
        // Snapshot #1: User Profile
        if ($user->profile) {
            $profileData = $user->profile->getAttributes();
            $profileData['job_id'] = $jobId;
            UserProfileHistory::create($profileData);
        }

        // Snapshot #2: User Educations
        foreach ($user->educations as $education) {
            $educationData = $education->getAttributes();
            $educationData['job_id'] = $jobId;
            UserEducationHistory::create($educationData);
        }

        // Snapshot #3: User Experiences
        foreach ($user->experiences as $experience) {
            $experienceData = $experience->getAttributes();
            $experienceData['job_id'] = $jobId;
            UserExperienceHistory::create($experienceData);
        }

        // Snapshot #4: User Publications
        foreach ($user->publications as $publication) {
            $publicationData = $publication->getAttributes();
            $publicationData['job_id'] = $jobId;
            UserPublicationHistory::create($publicationData);
        }

        // Snapshot #5: User Trainings
        foreach ($user->trainings as $training) {
            $trainingData = $training->getAttributes();
            $trainingData['job_id'] = $jobId;
            UserTrainingHistory::create($trainingData);
        }

        // Snapshot #6: User Languages
        foreach ($user->languageProficiencies as $language) {
            $languageData = $language->getAttributes();
            $languageData['job_id'] = $jobId;
            LanguageProficiencyHistory::create($languageData);
        }

        // Snapshot #7: User Referees
        foreach ($user->referees as $referee) {
            $refereeData = $referee->getAttributes();
            $refereeData['job_id'] = $jobId;
            RefereeHistory::create($refereeData);
        }

        // Snapshot #8: User Documents
        foreach ($user->documents as $document) {
            $documentData = $document->getAttributes();
            $documentData['job_id'] = $jobId;
            UserDocumentHistory::create($documentData);
        }
    }
}
