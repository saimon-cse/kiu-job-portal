<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class SpanshotService
{
    /**
     * Create a new user with the given data.
     *
     * @param array $data
     * @return User
     */
    public function snapshot(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (isset($data['role'])) {
            $role = Role::findByName($data['role']);
            $user->assignRole($role);
        }

        return $user;
    }
}


