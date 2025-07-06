<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserPublication;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPublicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the list of their publications.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create a new publication.
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update a specific publication.
     */
    public function update(User $user, UserPublication $userPublication)
    {
        return $user->id === $userPublication->user_id;
    }

    /**
     * Determine whether the user can delete a specific publication.
     */
    public function delete(User $user, UserPublication $userPublication)
    {
        return $user->id === $userPublication->user_id;
    }
}
