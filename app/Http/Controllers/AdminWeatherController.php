<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AdminWeatherController extends Controller
{
    /**
     * Show the form for editing weather API and locations configuration.
     */
    public function edit()
    {
        $setting = Setting::first() ?: new Setting();
        return view('admin.weather.edit', compact('setting'));
    }

    /**
     * Update weather API and locations settings in database.
     */
    public function update(Request $request)
    {
        $request->validate([
            'weather_api_key' => 'nullable|string|max:255',
            'weather_locations' => 'nullable|string|max:2000',
        ]);

        $setting = Setting::first() ?: new Setting();
        $setting->weather_api_key = $request->input('weather_api_key');
        $setting->weather_locations = $request->input('weather_locations');
        $setting->save();

        return redirect()->route('admin.weather.edit')->with('success', 'Weather API and locations configuration updated successfully!');
    }
}
