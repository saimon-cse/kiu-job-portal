<div class="space-y-6">
    <!-- Referee Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
        <div class="mt-1">
            <input type="text" name="name" id="name" value="{{ old('name', isset($referee) ? $referee->name : '') }}" required
                   placeholder="e.g., Dr. Jane Doe"
                   class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Designation -->
        <div>
            <label for="designation" class="block text-sm font-medium text-gray-700">Designation</label>
            <div class="mt-1">
                <input type="text" name="designation" id="designation" value="{{ old('designation', isset($referee) ? $referee->designation : '') }}"
                       placeholder="e.g., Professor"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
        <!-- Organization -->
        <div>
            <label for="organization" class="block text-sm font-medium text-gray-700">Organization</label>
            <div class="mt-1">
                <input type="text" name="organization" id="organization" value="{{ old('organization', isset($referee) ? $referee->organization : '') }}"
                       placeholder="e.g., University of Example"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <div class="mt-1">
                <input type="email" name="email" id="email" value="{{ old('email', isset($referee) ? $referee->email : '') }}"
                       placeholder="e.g., jane.doe@example.com"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
        <!-- Phone Number -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <div class="mt-1">
                <input type="tel" name="phone" id="phone" value="{{ old('phone', isset($referee) ? $referee->phone : '') }}"
                       placeholder="e.g., +1 (555) 987-6543"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
    </div>

    <!-- Address -->
    <div>
        <label for="address" class="block text-sm font-medium text-gray-700">Address (Optional)</label>
        <div class="mt-1">
            <textarea name="address" id="address" rows="3"
                      placeholder="e.g., Department of Physics, University of Example, 123 Science Ave, Knowledge City"
                      class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('address', isset($referee) ? $referee->address : '') }}</textarea>
        </div>
    </div>
</div>
