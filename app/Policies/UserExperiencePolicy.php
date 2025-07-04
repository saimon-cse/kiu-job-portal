<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserExperience;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserExperiencePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, UserExperience $userExperience): bool
    {
        return $user->id === $userExperience->user_id;
    }

    public function delete(User $user, UserExperience $userExperience): bool
    {
        return $user->id === $userExperience->user_id;
    }
}
