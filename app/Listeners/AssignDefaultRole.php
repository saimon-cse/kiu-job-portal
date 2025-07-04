<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Models\Role;

class AssignDefaultRole
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // The $event object contains the newly registered user instance.
        $user = $event->user;

        // Find the 'user' role. It's good practice to check if it exists.
        $userRole = Role::where('name', 'user')->first();

        if ($userRole) {
            // Assign the role to the user.
            $user->assignRole($userRole);
        } else {
            // Optional: Log an error or handle the case where the role doesn't exist.
            // This might happen if your seeders haven't run.
            // \Log::error("Default 'user' role not found for new user registration.");
        }
    }
}
