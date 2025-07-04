<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    /**
     * Get a setting value from the database.
     * It uses a cache to avoid repeated database queries.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        try {
            $settings = Cache::rememberForever('app_settings', function () {
                return Setting::all()->keyBy('key');
            });

            return $settings->get($key)->value ?? $default;
        } catch (\Exception $e) {
            // Return default value if there's an issue (e.g., DB not ready)
            return $default;
        }
    }
}
