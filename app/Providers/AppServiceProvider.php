<?php

namespace App\Providers;

use App\Http\ViewComposers\NavigationComposer;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\RoleHasPermission;
use App\Observers\MenuObserver;
use App\Observers\PermissionObserver;
use App\Observers\RoleHasPermissionObserver;
use Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Route;
use Str;

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
        // SIDEBAR
        View::composer('layouts.sidebar', NavigationComposer::class);

        // BREADCRUMBS
        View::composer('components.breadcrumbs', function ($view) {
            $currentRoute = Route::currentRouteName();
            $routeParts = explode('.', $currentRoute);
            $baseRoute = $routeParts[0];

            // Mencari menu dengan eager loading parent
            $menu = Menu::with(['parent.parent.parent'])
                ->where('route', $baseRoute)
                ->first();

            $breadcrumbs = collect();
            $title = 'Dashboard'; // Default title
            $icon = '<i class="bi bi-house"></i>'; // Default icon

            if ($menu) {
                // Bangun hierarki breadcrumbs
                $current = $menu;
                while ($current) {
                    $breadcrumbs->prepend($current);
                    $current = $current->parent;
                }

                // Set title dan icon dari parent pertama
                $parent = $breadcrumbs->first();
                $title = $parent->title;
                $icon = $parent->icon ? '<i class="material-icons-outlined">' . $parent->icon . '</i>' : '';
            }

            $view->with([
                'breadcrumbs' => $breadcrumbs,
                'title' => $title,
                'icon' => $icon
            ]);
        });

        // MENU PERMISSION
        View::composer('*', function ($view) {
            $route = Str::before(Route::currentRouteName(), '.');
            $menu  = Cache::rememberForever(
                "menu_{$route}",
                fn () =>
                Menu::where('route', $route)->first()
            );
            $view->with('menu', $menu);
        });
    }
}
