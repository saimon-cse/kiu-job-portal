<?php

namespace App\Policies;

use App\Models\LanguageProficiency;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LanguageProficiencyPolicy
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

    public function update(User $user, LanguageProficiency $languageProficiency): bool
    {
        return $user->id === $languageProficiency->user_id;
    }

    public function delete(User $user, LanguageProficiency $languageProficiency): bool
    {
        return $user->id === $languageProficiency->user_id;
    }
}
