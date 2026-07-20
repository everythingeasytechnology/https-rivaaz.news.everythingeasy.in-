<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'logo_path',
        'footer_text',
        'contact_email',
        'contact_phone',
        'contact_address',
        'weather_city',
        'weather_api_key',
        'weather_locations',
        'social_facebook',
        'social_twitter',
        'social_instagram',
        'social_linkedin',
        'live_tv_url',
        'live_tv_cover',
    ];

    /**
     * Automatically convert YouTube/Vimeo URLs to embed format for Live TV player.
     */
    public function getLiveTvUrlAttribute($value)
    {
        if (empty($value)) {
            return '';
        }

        // 1. YouTube Live Stream channel ID check (e.g. channel=UC...)
        if (str_contains($value, 'live_stream?channel=')) {
            return $value;
        }

        // 2. YouTube standard links
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/live\/)([a-zA-Z0-9_-]+)/', $value, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        // 3. Vimeo links
        if (preg_match('/vimeo\.com\/([0-9]+)/', $value, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1];
        }

        return $value;
    }

    /**
     * Mutator to clean and resolve any YouTube stream URL on save.
     */
    public function setLiveTvUrlAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['live_tv_url'] = '';
            return;
        }

        // 1. YouTube Live Stream channel ID check (already clean)
        if (str_contains($value, 'live_stream?channel=')) {
            $this->attributes['live_tv_url'] = $value;
            return;
        }

        // 2. YouTube standard/live watch links
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/live\/)([a-zA-Z0-9_-]+)/', $value, $matches)) {
            $this->attributes['live_tv_url'] = 'https://www.youtube.com/embed/' . $matches[1];
            return;
        }

        // 3. YouTube channel ID directly in path (e.g., youtube.com/channel/UC...)
        if (preg_match('/youtube\.com\/channel\/(UC[a-zA-Z0-9_-]{22})/', $value, $matches)) {
            $this->attributes['live_tv_url'] = 'https://www.youtube.com/embed/live_stream?channel=' . $matches[1];
            return;
        }

        // 4. YouTube custom handle/c/username links (e.g., youtube.com/@ABPNews or youtube.com/@ABPNews/live)
        if (preg_match('/youtube\.com\/(?:@|c\/|user\/)?([a-zA-Z0-9_-]+)/', $value, $matches)) {
            $identifier = $matches[1];
            
            if (str_starts_with($identifier, 'UC') && strlen($identifier) === 24) {
                $this->attributes['live_tv_url'] = 'https://www.youtube.com/embed/live_stream?channel=' . $identifier;
                return;
            }

            try {
                $chUrl = 'https://www.youtube.com/' . (str_starts_with($identifier, '@') ? '' : '@') . $identifier;
                
                $options = [
                    'http' => [
                        'method' => 'GET',
                        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n",
                        'timeout' => 4
                    ]
                ];
                $context = stream_context_create($options);
                $html = @file_get_contents($chUrl, false, $context);
                
                if ($html) {
                    if (preg_match('/"channelId":"(UC[a-zA-Z0-9_-]{22})"/', $html, $chMatches)) {
                        $this->attributes['live_tv_url'] = 'https://www.youtube.com/embed/live_stream?channel=' . $chMatches[1];
                        return;
                    }
                    if (preg_match('/<meta itemprop="channelId" content="(UC[a-zA-Z0-9_-]{22})"/', $html, $chMatches)) {
                        $this->attributes['live_tv_url'] = 'https://www.youtube.com/embed/live_stream?channel=' . $chMatches[1];
                        return;
                    }
                }
            } catch (\Exception $e) {
                // Ignore and fallback
            }
        }

        // 5. Vimeo links
        if (preg_match('/vimeo\.com\/([0-9]+)/', $value, $matches)) {
            $this->attributes['live_tv_url'] = 'https://player.vimeo.com/video/' . $matches[1];
            return;
        }

        $this->attributes['live_tv_url'] = $value;
    }
}
