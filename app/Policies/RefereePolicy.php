<?php

namespace App\Policies;

use App\Models\Referee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RefereePolicy
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

    public function update(User $user, Referee $referee): bool
    {
        return $user->id === $referee->user_id;
    }

    public function delete(User $user, Referee $referee): bool
    {
        return $user->id === $referee->user_id;
    }
}
