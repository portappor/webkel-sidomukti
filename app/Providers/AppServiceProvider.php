<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Setting;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            static $logoSetting = null;
            static $fetched = false;

            if (!$fetched) {
                $logoSetting = Setting::where('key', 'logo_kelurahan')->value('value');
                $fetched = true;
            }

            $defaultLogo = 'https://upload.wikimedia.org/wikipedia/commons/e/e6/Logo_Kabupaten_Probolinggo_-_Seal_of_Probolinggo_Regency.svg';

            if (!empty($logoSetting)) {
                $app_logo = Str::startsWith($logoSetting, ['http://', 'https://'])
                    ? $logoSetting
                    : Storage::url($logoSetting);
            } else {
                $app_logo = $defaultLogo;
            }

            $view->with('app_logo', $app_logo);
            $view->with('logoUrl', $app_logo);
        });
    }
}

