<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserEducation;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserEducationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     * All authenticated users can view their own list.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     * All authenticated users can add education records.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * A user can only update an education record if they own it.
     */
    public function update(User $user, UserEducation $userEducation): bool
    {
        return $user->id === $userEducation->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     * A user can only delete an education record if they own it.
     */
    public function delete(User $user, UserEducation $userEducation): bool
    {
        return $user->id === $userEducation->user_id;
    }
}
