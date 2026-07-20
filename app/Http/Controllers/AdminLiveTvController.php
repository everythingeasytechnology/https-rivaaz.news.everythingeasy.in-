<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AdminLiveTvController extends Controller
{
    /**
     * Show Live TV edit form.
     */
    public function edit()
    {
        $setting = Setting::first() ?: new Setting();
        return view('admin.livetv.edit', compact('setting'));
    }

    /**
     * Update Live TV stream settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'live_tv_url' => 'nullable|string|max:255',
            'live_tv_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $setting = Setting::first() ?: new Setting();

        $data = $request->only(['live_tv_url']);

        if ($request->hasFile('live_tv_cover')) {
            // Delete old cover
            if ($setting->live_tv_cover && file_exists(public_path($setting->live_tv_cover))) {
                @unlink(public_path($setting->live_tv_cover));
            }

            $file = $request->file('live_tv_cover');
            $filename = 'live_tv_' . time() . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads'))) {
                mkdir(public_path('uploads'), 0755, true);
            }
            
            $file->move(public_path('uploads'), $filename);
            $data['live_tv_cover'] = '/uploads/' . $filename;
        }

        $setting->fill($data);
        $setting->save();

        return redirect()->back()->with('success', 'Live TV stream settings updated successfully!');
    }
}
