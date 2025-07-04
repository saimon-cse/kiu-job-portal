<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserDocumentPolicy
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

    public function update(User $user, UserDocument $userDocument): bool
    {
        // Note: You might not need an 'update' for documents,
        // but it's here for consistency. Usually, you delete and re-upload.
        return $user->id === $userDocument->user_id;
    }

    public function delete(User $user, UserDocument $userDocument): bool
    {
        return $user->id === $userDocument->user_id;
    }
}
