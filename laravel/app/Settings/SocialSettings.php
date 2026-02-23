<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SocialSettings extends Settings
{
    public ?string $linkedin_url;
    public ?string $youtube_url;
    public ?string $instagram_url;
    public ?string $tiktok_url;

    public static function group(): string
    {
        return 'social';
    }
}
