<?php

namespace App\Policies;

use App\Models\ApplicationHistory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationHistoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     * A user can only delete their own application, and only if it's still 'pending'.
     */
    public function delete(User $user, ApplicationHistory $application)
    {
        return $user->id === $application->user_id && $application->status === 'pending';
    }
}
