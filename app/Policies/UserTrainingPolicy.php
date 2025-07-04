<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserTraining;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserTrainingPolicy
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

    public function update(User $user, UserTraining $userTraining): bool
    {
        return $user->id === $userTraining->user_id;
    }

    public function delete(User $user, UserTraining $userTraining): bool
    {
        return $user->id === $userTraining->user_id;
    }
}
