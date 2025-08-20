<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share settings with all views
        // $settings['logo'] = Setting::get('logo');
        // $settings['light_logo'] = Setting::get('light_logo');
        // $settings['favicon'] = Setting::get('favicon');
        // $settings['site_title'] = Setting::get('site_title');
        // $settings['site_description'] = Setting::get('site_description');
        // $settings['boxed_page'] = Setting::get('boxed_page');
        // $settings['fixed_footer'] = Setting::get('fixed_footer');
        // $settings['display_footer'] = Setting::get('display_footer');
        // View::share('settings', $settings);
    }
}
