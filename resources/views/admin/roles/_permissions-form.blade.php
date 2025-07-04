{{-- This partial displays the permission checkboxes grouped by resource. --}}
{{-- It expects $permissions (all available) and optionally $rolePermissions (currently assigned) --}}

<div>
    <label class="block text-lg font-semibold text-gray-800">Permissions</label>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($permissions as $group => $permissionGroup)
            <div class="p-4 border rounded-lg bg-gray-50">
                <h4 class="font-bold mb-3 border-b pb-2 capitalize">{{ $group }} Permissions</h4>
                <div class="space-y-2">
                    @foreach($permissionGroup as $permission)
                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="permissions[]"
                                   value="{{ $permission->name }}"
                                   id="permission_{{ $permission->id }}"
                                   @if(isset($rolePermissions) && in_array($permission->name, $rolePermissions))
                                       checked
                                   @elseif(is_array(old('permissions')) && in_array($permission->name, old('permissions')))
                                       checked
                                   @endif
                                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <label for="permission_{{ $permission->id }}" class="ml-2 text-sm text-gray-700">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
