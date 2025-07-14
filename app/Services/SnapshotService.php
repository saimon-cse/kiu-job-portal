<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class SnapshotService
{
    /**
     * An array that maps a user's "live data" relationship to its corresponding "history" model.
     */
    protected $snapshotMap = [
        'profile'               => \App\Models\UserProfileHistory::class,
        'educations'            => \App\Models\UserEducationHistory::class,
        'experiences'           => \App\Models\UserExperienceHistory::class,
        'publications'          => \App\Models\UserPublicationHistory::class,
        'trainings'             => \App\Models\UserTrainingHistory::class,
        'languageProficiencies' => \App\Models\LanguageProficiencyHistory::class,
        'referees'              => \App\Models\RefereeHistory::class,
        'documents'             => \App\Models\UserDocumentHistory::class,
        'awards'                => \App\Models\UserAwardHistory::class,
    ];

    /**
     * Creates a complete data snapshot for a user applying for a specific job.
     */
    public function createForJob(User $user, $jobId)
    {
        DB::transaction(function () use ($user, $jobId) {
            foreach ($this->snapshotMap as $relationshipName => $historyModelClass) {
                $liveData = $user->{$relationshipName};
                if (!$liveData) {
                    continue;
                }

                $itemsToSnapshot = $liveData instanceof \Illuminate\Database\Eloquent\Model
                    ? [$liveData]
                    : $liveData;

                foreach ($itemsToSnapshot as $item) {
                    // --- THE FIX IS HERE ---
                    $this->copyDataToHistory($item, $historyModelClass, $jobId);
                }
            }
        });
    }

    /**
     * A private helper method to copy attributes from a source model to a history model.
     * This version correctly removes keys that should not be copied.
     */
    private function copyDataToHistory($sourceModel, $historyModelClass, $jobId)
    {
        // Get all attributes from the source model.
        $attributes = $sourceModel->getAttributes();

        // --- THIS IS THE CRITICAL FIX ---
        // Unset keys that we don't want to copy to the history table.
        // The database should generate a new 'id' for the history record.
        unset($attributes['id']);
        unset($attributes['created_at']);
        unset($attributes['updated_at']);
        // --- END FIX ---

        // Add the job_id to link this history record to the specific application.
        $attributes['job_id'] = $jobId;

        // Create the new history record with the cleaned attributes.
        $historyModelClass::create($attributes);
    }
}
