<?php

namespace App\Providers;

use App\Models\Partner;
use App\Models\ProgramCategory;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Share site settings (cached 5 min)
        View::composer(['layouts.app', 'layouts.admin', 'components.*', 'pages.*', 'admin.*'], function ($view) {
            try {
                $settings = Cache::remember('site_settings:all', 300, function () {
                    return SiteSetting::all_settings();
                });
            } catch (\Throwable $e) {
                $settings = [];
            }
            $view->with('settings', $settings);
        });

        View::composer(['layouts.app', 'components.header', 'components.footer'], function ($view) {
            try {
                [$navCategories, $footerPartners] = Cache::remember('public_nav_data:v1', 600, function () {
                    return [
                        ProgramCategory::active()->orderBy('sort_order')->limit(6)->get(),
                        Partner::active()->whereIn('type', ['supervisor', 'partner'])->orderBy('sort_order')->get(),
                    ];
                });
            } catch (\Throwable $e) {
                $navCategories = collect();
                $footerPartners = collect();
            }
            $view->with(compact('navCategories', 'footerPartners'));
        });
    }
}
