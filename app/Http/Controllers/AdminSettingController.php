<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    /**
     * Show settings edit form.
     */
    public function edit()
    {
        $setting = Setting::first() ?: new Setting();
        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'footer_text' => 'nullable|string',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'contact_address' => 'nullable|string|max:1000',
            'social_facebook' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
        ]);

        $setting = Setting::first() ?: new Setting();

        $data = $request->only([
            'site_name',
            'footer_text',
            'contact_email',
            'contact_phone',
            'contact_address',
            'social_facebook',
            'social_twitter',
            'social_instagram',
            'social_linkedin',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Ensure uploads directory exists
            if (!file_exists(public_path('uploads'))) {
                mkdir(public_path('uploads'), 0755, true);
            }
            
            $file->move(public_path('uploads'), $filename);
            $data['logo_path'] = '/uploads/' . $filename;
        }

        $setting->fill($data);
        $setting->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
