<div>
    <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700">{{ $setting->display_name }}</label>
    <div class="mt-1">
        @switch($setting->type)
            @case('text')
            @case('number')
                {{-- UPDATED CLASS FOR INPUTS --}}
                <input type="{{ $setting->type }}" name="{{ $setting->key }}" id="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}" class="block w-full md:w-1/2 px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 sm:text-sm">
                @break
            @case('textarea')
                {{-- UPDATED CLASS FOR TEXTAREA --}}
                <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="4" class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 sm:text-sm">{{ old($setting->key, $setting->value) }}</textarea>
                @break
            @case('image')
                <div>
                    @if ($setting->value)
                        <img src="{{ Storage::url($setting->value) }}" alt="{{ $setting->display_name }}" class="h-16 w-auto object-contain bg-gray-100 p-2 rounded-md mb-2">
                    @endif
                    <input type="file" name="{{ $setting->key }}" id="{{ $setting->key }}" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                </div>
                @break
            @case('checkbox')
                <div class="flex items-center">
                    <input type="hidden" name="{{ $setting->key }}" value="0">
                    <input type="checkbox" name="{{ $setting->key }}" id="{{ $setting->key }}" value="1" @if(old($setting->e, $setting->value) == '1') checked @endif class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="{{ $setting->key }}" class="ml-2 block text-sm text-gray-900">Enable this feature</label>
                </div>
                @break
        @endswitch
    </div>
</div>
