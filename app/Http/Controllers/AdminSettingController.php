<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'footer_text' => 'nullable|string',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'contact_address' => 'nullable|string|max:1000',
            'social_facebook' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'adsense_script' => 'nullable|string',
            'adsense_header_code' => 'nullable|string',
            'adsense_sidebar_code' => 'nullable|string',
            'adsense_article_code' => 'nullable|string',
            'adsense_enabled' => 'nullable|boolean',
            
            // Manual Ad Banners Validation
            'ad_top_banner_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
            'ad_top_banner_image' => 'nullable|string|max:1000',
            'ad_top_banner_link' => 'nullable|string|max:1000',
            'ad_top_banner_code' => 'nullable|string',
            
            'ad_sidebar_1_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
            'ad_sidebar_1_image' => 'nullable|string|max:1000',
            'ad_sidebar_1_link' => 'nullable|string|max:1000',
            'ad_sidebar_1_code' => 'nullable|string',
            
            'ad_sidebar_2_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
            'ad_sidebar_2_image' => 'nullable|string|max:1000',
            'ad_sidebar_2_link' => 'nullable|string|max:1000',
            'ad_sidebar_2_code' => 'nullable|string',
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
            'adsense_script',
            'adsense_header_code',
            'adsense_sidebar_code',
            'adsense_article_code',
            'ad_top_banner_link',
            'ad_top_banner_code',
            'ad_sidebar_1_link',
            'ad_sidebar_1_code',
            'ad_sidebar_2_link',
            'ad_sidebar_2_code',
        ]);

        $data['adsense_enabled'] = $request->has('adsense_enabled');
        $data['ad_top_banner_enabled'] = $request->has('ad_top_banner_enabled');
        $data['ad_sidebar_1_enabled'] = $request->has('ad_sidebar_1_enabled');
        $data['ad_sidebar_2_enabled'] = $request->has('ad_sidebar_2_enabled');

        $adsDir = public_path('uploads/ads');
        if (!File::exists($adsDir)) {
            File::makeDirectory($adsDir, 0755, true);
        }

        // 1. Logo upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $data['logo_path'] = '/uploads/' . $filename;
        }

        // 2. Top Banner Image
        if ($request->hasFile('ad_top_banner_file')) {
            $file = $request->file('ad_top_banner_file');
            $filename = 'top_banner_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($adsDir, $filename);
            $data['ad_top_banner_image'] = '/uploads/ads/' . $filename;
        } elseif ($request->filled('ad_top_banner_image')) {
            $data['ad_top_banner_image'] = $request->ad_top_banner_image;
        }

        // 3. Sidebar Ad 1 Image
        if ($request->hasFile('ad_sidebar_1_file')) {
            $file = $request->file('ad_sidebar_1_file');
            $filename = 'sidebar_1_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($adsDir, $filename);
            $data['ad_sidebar_1_image'] = '/uploads/ads/' . $filename;
        } elseif ($request->filled('ad_sidebar_1_image')) {
            $data['ad_sidebar_1_image'] = $request->ad_sidebar_1_image;
        }

        // 4. Sidebar Ad 2 Image
        if ($request->hasFile('ad_sidebar_2_file')) {
            $file = $request->file('ad_sidebar_2_file');
            $filename = 'sidebar_2_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($adsDir, $filename);
            $data['ad_sidebar_2_image'] = '/uploads/ads/' . $filename;
        } elseif ($request->filled('ad_sidebar_2_image')) {
            $data['ad_sidebar_2_image'] = $request->ad_sidebar_2_image;
        }

        $setting->fill($data);
        $setting->save();

        return redirect()->back()->with('success', 'Settings and advertisement banners updated successfully!');
    }
}
