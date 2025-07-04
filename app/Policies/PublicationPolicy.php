<?php

namespace App\Policies;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PublicationPolicy
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

    public function update(User $user, Publication $publication): bool
    {
        return $user->id === $publication->user_id;
    }

    public function delete(User $user, Publication $publication): bool
    {
        return $user->id === $publication->user_id;
    }
}
