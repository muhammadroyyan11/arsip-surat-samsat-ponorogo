<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Support\Facades\View::composer('layouts.sidebar', function ($view) {
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user && clone $user) {
                if ($user->role === 'superadmin') {
                    $sections = \App\Models\MenuSection::with(['menus' => function($q) { $q->orderBy('order'); }])->orderBy('order')->get();
                } else {
                    $menuIds = $user->userMenus()->pluck('menu_id');
                    $sections = \App\Models\MenuSection::with(['menus' => function($q) use ($menuIds) {
                        $q->whereIn('id', $menuIds)->orderBy('order');
                    }])->whereHas('menus', function($q) use ($menuIds) {
                        $q->whereIn('id', $menuIds);
                    })->orderBy('order')->get();
                }
                $view->with('sidebar_sections', $sections);
            }
        });
    }
}
