<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    const TABLE_NAME = 'settings';

    const FILLABLE = [
        'site_settings',
        'site_title',
        'site_description',
        'maintenance_message',
        'logo_login',
        'logo',
        'light_logo',
        'favicon',
        'boxed_page',
        'fixed_footer',
        'display_footer',
        'header_background_color',
        'header_text_color',
        'navbar_background_color',
        'navbar_text_color',
    ];

    protected $fillable = [
        'name',
        'value',
    ];

    public static function get($name = null)
    {
        if (!Schema::hasTable('settings')) {
            return array_combine(self::FILLABLE, array_fill(0, count(self::FILLABLE), null));
        }

        if (!$name) {
            $settings = Cache::rememberForever("settings.list", function () {
                return self::whereIn('name', self::FILLABLE)->pluck('value', 'name')->toArray();
            });
            return array_replace(array_combine(self::FILLABLE, array_fill(0, count(self::FILLABLE), null)), $settings);
        }

        return Cache::rememberForever("settings.$name", function () use ($name) {
            return self::where('name', $name)->first()?->value;
        });
    }

    public static function set($data): void
    {
        Cache::forget("settings.list");
        foreach ($data as $item) {
            self::updateOrCreate(['name' => $item['name']], ['value' => $item['value']]);
        }
        self::get();
    }

    public function getActivityLogNameAttribute(): string
    {
        return __('label.columns.settings.site_settings');
    }
}
