<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogActivityHelper;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalCrudObserver;


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
        // ===============================
        // AUTO REGISTER OBSERVER KE SEMUA MODEL
        // ===============================

        $modelPath = app_path('Models');
        $files = File::allFiles($modelPath);

        foreach ($files as $file) {

            $class = 'App\\Models\\' . str_replace(
                ['/', '.php'],
                ['\\', ''],
                $file->getRelativePathname()
            );

            if (class_exists($class) && is_subclass_of($class, Model::class)) {

                // Jangan observe LogAktivitas sendiri
                if ($class === \App\Models\LogAktivitas::class) {
                    continue;
                }

                $class::observe(GlobalCrudObserver::class);
            }
        }

        // ===============================
        // LOG AKSES MENU (punya kamu)
        // ===============================

        Route::matched(function ($event) {

            $request = request();

            if (!$request->isMethod('GET')) return;
            if ($request->ajax()) return;
            if (!Auth::check()) return;

            $route = $event->route;

            $ignoredRoutes = [
                'dashboard',
                'profile.edit',
                'profile.update',
                'profile.destroy',
            ];

            if (in_array($route->getName(), $ignoredRoutes)) return;

            $uri  = $route->uri();
            $name = $route->getName() ?? '-';

            LogActivityHelper::log(
                'Akses menu | Route: ' . $name . ' | URI: /' . $uri
            );
        });
    }
}
