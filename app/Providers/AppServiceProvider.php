<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Repositories\SystemUserRepository;
use App\Models\User;
class AppServiceProvider extends ServiceProvider
{
/**
     * Register any application services.
     */
public function register(): void
    {
// Binding SystemUserRepository to the service container
$this->app->bind(SystemUserRepository::class, function ($app) {
return new SystemUserRepository(new User());
        });
$this->app->bind(
            \App\Repositories\SlValuatedMaterialRepository::class,
            \App\Repositories\SlValuatedMaterialRepository::class
        );
$this->app->bind(
            \App\Repositories\AuditTrailRepository::class,
            \App\Repositories\AuditTrailRepository::class
        );
    }
/**
     * Bootstrap any application services.
     */
public function boot(): void
    {
//
    }
}