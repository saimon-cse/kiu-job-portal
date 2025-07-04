<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Authorize the action based on the 'manage-users' permission
        $this->authorize('manage-users');

        // Eager load roles to prevent N+1 database queries in the view
        $users = User::with('roles')->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('manage-users');

        // Fetch all role names to populate the form's role selector
        $roles = Role::pluck('name', 'name')->all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('manage-users');

        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles' => 'required|array',
            'roles.*' => 'string|exists:roles,name', // Ensure every role exists
        ]);

        // Create the new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Optionally verify user emails by default
        ]);

        // Assign the selected roles to the new user
        $user->assignRole($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $this->authorize('manage-users');

        // Fetch all available roles
        $roles = Role::pluck('name', 'name')->all();

        // Get the names of the roles currently assigned to the user
        $userRoles = $user->roles->pluck('name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('manage-users');

        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            // Ensure the email is unique, ignoring the current user's record
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // Password is not required for an update
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'roles' => 'required|array',
            'roles.*' => 'string|exists:roles,name',
        ]);

        // Prepare the data for updating
        $data = $request->only('name', 'email');
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        // Update the user's details
        $user->update($data);

        // Sync roles - this removes old roles and adds new ones
        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $this->authorize('manage-users');

        // Guard Clause: Prevent deletion of the super-admin or one's own account.
        if ($user->hasRole('super-admin')) {
            return back()->with('error', 'The Super Admin account cannot be deleted.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}
