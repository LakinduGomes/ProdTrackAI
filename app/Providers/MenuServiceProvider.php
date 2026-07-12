<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    //set menu permission for user modules
    public function boot(): void
    {
        // Share menu data with all views
        View::composer('*', function ($view) {
            if (Auth::check()) {

                $user_modules = DB::table('tbl_user_permissions')
                    ->select('id', 'module', 'add_permission')
                    ->where('user', Auth::id())
                    ->distinct()
                    ->get();

                $view->with('user_modules', $user_modules);
            }
        });
    }
}
