<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display a listing of the settings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Group settings by their 'group' attribute for easy display in the view.
        $settingsByGroup = Setting::all()->groupBy('group');

        return view('admin.settings.index', compact('settingsByGroup'));
    }

    /**
     * Update the specified settings in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Basic validation rules, you can create a FormRequest for more complex rules.
        $request->validate([
            'site_title' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'jobs_per_page' => 'required|integer|min:1|max:50',
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'site_favicon' => 'nullable|image|mimes:png,ico|max:512',
        ]);

        // Get all settings from the database to loop through them
        $settings = Setting::all();

        foreach ($settings as $setting) {
            $key = $setting->key;

            // Handle checkbox type
            if ($setting->type === 'checkbox') {
                $setting->value = $request->has($key) ? '1' : '0';
                $setting->save();
                continue;
            }

            // Handle image file uploads
            if ($setting->type === 'image' && $request->hasFile($key)) {
                // Delete the old file if it exists
                if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                    Storage::disk('public')->delete($setting->value);
                }
                // Store the new file and save the path
                $path = $request->file($key)->store('settings', 'public');
                $setting->value = $path;
                $setting->save();
                continue;
            }

            // Handle all other types (text, textarea, number)
            if ($request->has($key)) {
                $setting->value = $request->input($key);
                $setting->save();
            }
        }

        // CRITICAL: Forget the cache so the new settings are loaded.
        Cache::forget('app_settings');

        return redirect()->back()->with('success', 'Settings have been updated successfully!');
    }
}
