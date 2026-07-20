<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'site_name' => 'द उत्तराखंड नाउ',
            'logo_path' => '/logo.jpeg',
            'footer_text' => 'उत्कृष्ट पत्रकारिता, वास्तविक समय के समाचार बुलेटिन और उच्च गुणवत्ता वाली मीडिया दीर्घाओं के साथ एक अग्रणी हिंदी समाचार पोर्टल।',
            'contact_email' => 'contact@rivaaznews.in',
            'contact_phone' => '+91 98765 43210',
            'contact_address' => 'देहरादून कार्यालय: 12, सुभाष रोड, देहरादून, उत्तराखंड - 248001',
            'weather_locations' => 'Dehradun, Haridwar, Nainital, New Delhi',
            'social_facebook' => 'https://facebook.com',
            'social_twitter' => 'https://twitter.com',
            'social_instagram' => 'https://instagram.com',
            'social_linkedin' => 'https://linkedin.com',
            'live_tv_url' => 'https://www.youtube.com/embed/live_stream?channel=UCqYw-CTd1dU2yGI71sGBqNw',
            'live_tv_cover' => '/uploads/live_tv_default.png',
        ]);
    }
}
