<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserAward;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserAwardPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, UserAward $userAward)
    {
        return $user->id === $userAward->user_id;
    }

    public function delete(User $user, UserAward $userAward)
    {
        return $user->id === $userAward->user_id;
    }
}
