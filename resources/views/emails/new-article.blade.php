<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }}</title>
</head>
<body style="margin:0;background:#f4f4f4;font-family:Arial,Helvetica,sans-serif;color:#212529;">
    <div style="max-width:640px;margin:0 auto;padding:24px 12px;">
        <div style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 3px 12px rgba(0,0,0,.08);">
            <div style="background:#e50000;color:#ffffff;padding:18px 24px;font-size:20px;font-weight:700;">
                {{ config('app.name') }}
            </div>

            @if($article->image_path || ($article->media_type === 'image_link' && $article->media_link))
                <img src="{{ $article->image_path ? url($article->image_path) : $article->media_link }}" alt="{{ $article->title }}" style="display:block;width:100%;max-height:340px;object-fit:cover;">
            @endif

            <div style="padding:28px 24px;">
                <div style="font-size:13px;font-weight:700;color:#e50000;text-transform:uppercase;margin-bottom:10px;">नई खबर</div>
                <h1 style="font-size:26px;line-height:1.3;margin:0 0 14px;">{{ $article->title }}</h1>

                @if($article->summary || $article->subtitle)
                    <p style="font-size:16px;line-height:1.7;color:#5f6368;margin:0 0 24px;">
                        {{ $article->summary ?: $article->subtitle }}
                    </p>
                @endif

                <a href="{{ url('/news/'.$article->slug) }}" style="display:inline-block;background:#e50000;color:#ffffff;text-decoration:none;font-weight:700;padding:12px 22px;border-radius:6px;">पूरी खबर पढ़ें</a>
            </div>

            <div style="border-top:1px solid #eeeeee;padding:18px 24px;color:#777777;font-size:12px;line-height:1.5;">
                आपने यह ईमेल इसलिए प्राप्त किया क्योंकि आपने {{ config('app.name') }} की खबरों को सब्सक्राइब किया है।
            </div>
        </div>
    </div>
</body>
</html>
