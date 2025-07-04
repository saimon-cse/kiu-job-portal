<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Authorize the action
        $this->authorize('manage-roles');

        // Eager load permissions to prevent N+1 query issues on the index page
        $roles = Role::with('permissions')->latest()->paginate(10);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('manage-roles');

        // Group permissions by resource name (e.g., 'jobs', 'users') for a cleaner UI
        $permissions = Permission::all()->groupBy(function($permission) {
            // Extracts the first part of the permission name, e.g., 'manage-jobs' -> 'manage'
            return explode('-', $permission->name)[0];
        });

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('manage-roles');

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name', // Validate each permission exists
        ]);

        // Create the role
        $role = Role::create(['name' => $request->name]);

        // Assign permissions if any were provided
        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Role $role)
    {
        $this->authorize('manage-roles');

        // Guard Clause: Prevent editing of the Super Admin role.
        if ($role->name === 'super-admin') {
            return redirect()->route('admin.roles.index')->with('error', 'The Super Admin role cannot be edited.');
        }

        // Group permissions for the view
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('-', $permission->name)[0];
        });

        // Get the names of the permissions this role currently has
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('manage-roles');

        // Guard Clause: Prevent editing of the Super Admin role.
        if ($role->name === 'super-admin') {
            return back()->with('error', 'The Super Admin role cannot be modified.');
        }

        $request->validate([
            // Ensure the name is unique, ignoring the current role's name
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        // Update the role's name
        $role->update(['name' => $request->name]);

        // Sync permissions. This adds new ones and removes deselected ones.
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        $this->authorize('manage-roles');

        // Guard Clause: Prevent deletion of core system roles.
        if (in_array($role->name, ['super-admin', 'admin', 'user'])) {
            return back()->with('error', "Cannot delete the core '{$role->name}' role.");
        }

        // The 'deleting' event on the Role model from the Spatie package
        // will automatically handle detaching users and permissions.
        $role->delete();

        return back()->with('success', 'Role deleted successfully.');
    }
}
