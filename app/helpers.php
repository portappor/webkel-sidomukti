<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Get a setting value by key.
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key = null, $default = null)
    {
        if ($key === null) {
            return Setting::pluck('value', 'key')->all();
        }
        $val = Setting::where('key', $key)->value('value');
        return ($val !== null && $val !== '') ? $val : $default;
    }
}
